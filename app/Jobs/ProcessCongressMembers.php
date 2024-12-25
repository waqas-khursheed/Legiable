<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\{
    Member,
    MemberPartyHistory,
    MemberTerm,
    MemberLeadership
};

class ProcessCongressMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $congress;
    protected $limit;
    protected $offset;

    /**
     * Create a new job instance.
     */
    public function __construct($congress, $limit, $offset)
    {
        $this->congress = $congress;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = config('services.congress.api_key');

        try {
            do {
                // Fetch the list of members for the specific Congress with pagination
                $response = Http::get("https://api.congress.gov/v3/member/congress/{$this->congress}", [
                    'api_key' => $apiKey,
                    'format' => 'json',
                    'limit' => $this->limit,
                    'offset' => $this->offset,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $members = $data['members'] ?? [];

                    if (empty($members)) {
                        Log::info('No more members to fetch.');
                        break; // Exit loop if no more members are available
                    }

                    foreach ($members as $member) {
                        $bioguideId = $member['bioguideId'] ?? null;
                        $partyName =  $member['partyName'] ?? null;

                        if (!$bioguideId) {
                            Log::warning('Missing bioguideId for member data', ['member' => $member]);
                            continue;
                        }

                        // Fetch detailed information for the member
                        $detailsResponse = Http::get("https://api.congress.gov/v3/member/{$bioguideId}", [
                            'api_key' => $apiKey,
                            'format' => 'json',
                        ]);

                        $memberDetails = $detailsResponse->json()['member'];

                        Log::info($memberDetails);
                        // Prepare data for the members table
                        $memberData = [
                            'bioguideId' => $bioguideId,
                            'partyName' => $partyName,
                            'birthYear' => $memberDetails['birthYear'] ?? null,
                            'currentMember' => $memberDetails['currentMember'] ?? false,
                            'depiction_attribution' => $memberDetails['depiction']['attribution'] ?? null,
                            'depiction_imageUrl' => $memberDetails['depiction']['imageUrl'] ?? null,
                            'directOrderName' => $memberDetails['directOrderName'] ?? null,
                            'firstName' => $memberDetails['firstName'] ?? null,
                            'honorificName' => $memberDetails['honorificName'] ?? null,
                            'invertedOrderName' => $memberDetails['invertedOrderName'] ?? null,
                            'lastName' => $memberDetails['lastName'] ?? null,
                            'officialWebsiteUrl' => $memberDetails['officialWebsiteUrl'] ?? null,
                            'state' => $memberDetails['state'] ?? null,
                        ];

                        // Save or update the member data
                        $savedMember = Member::updateOrCreate(
                            ['bioguideId' => $bioguideId],
                            $memberData
                        );

                        $memberId = $savedMember->id;

                        // Handle party history data
                        if (isset($memberDetails['partyHistory'])) {
                            foreach ($memberDetails['partyHistory'] as $history) {
                                $partyHistoryData = [
                                    'member_id' => $memberId, // Reference to member ID
                                    'bioguideId' => $bioguideId,
                                    'partyAbbreviation' => $history['partyAbbreviation'] ?? null,
                                    'partyName' => $history['partyName'] ?? null,
                                    'partyStartYear' => $history['startYear'] ?? null,
                                ];

                                // Log the data before saving
                                // Log::info('Saving party history data', ['data' => $partyHistoryData]);

                                // Save or update the party history data
                                MemberPartyHistory::updateOrCreate(
                                    [
                                        'member_id' => $memberId,
                                        'partyAbbreviation' => $partyHistoryData['partyAbbreviation'],
                                        'partyStartYear' => $partyHistoryData['partyStartYear'],
                                    ],
                                    $partyHistoryData
                                );
                            }
                        }

                        // Handle leadership data
                        if (isset($memberDetails['leadership'])) {
                            foreach ($memberDetails['leadership'] as $leadership) {
                                $leadershipData = [
                                    'member_id' => $memberId, // Reference to member ID
                                    'bioguideId' => $bioguideId,
                                    'congress' => $leadership['congress'] ?? null,
                                    'type' => $leadership['type'] ?? null,
                                ];

                                // Save or update the leadership data
                                MemberLeadership::updateOrCreate(
                                    [
                                        'member_id' => $memberId,
                                        'congress' => $leadershipData['congress'],
                                        'type' => $leadershipData['type'],
                                    ],
                                    $leadershipData
                                );
                            }
                        }

                        // Fetch and save member terms data
                        if (isset($memberDetails['terms'])) {
                            foreach ($memberDetails['terms'] as $term) {
                                $termData = [
                                    'member_id' => $memberId, // Reference to member ID
                                    'bioguideId' => $bioguideId,
                                    'chamber' => $term['chamber'] ?? null,
                                    'congress' => $term['congress'] ?? null,
                                    'district' => $term['district'] ?? null,
                                    'startYear' => $term['startYear'] ?? null,
                                    'endYear' => $term['endYear'] ?? null,
                                    'memberType' => $term['memberType'] ?? null,
                                    'stateCode' => $term['stateCode'] ?? null,
                                    'stateName' => $term['stateName'] ?? null,
                                ];

                                // Save or update the term data
                                MemberTerm::updateOrCreate(
                                    [
                                        'member_id' => $memberId,
                                        'congress' => $termData['congress'],
                                        'startYear' => $termData['startYear'],
                                    ],
                                    $termData
                                );
                            }
                        }
                    }

                    // Increment the offset for the next page of results
                    $this->offset += $this->limit;
                } else {
                    Log::error('Failed to fetch member list with status: ' . $response->status());
                    break; // Exit loop if the request fails
                }
            } while (true);

            Log::info('All member details, party histories, and terms fetched and saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching member data: ' . $e->getMessage());
        }
    }
}
