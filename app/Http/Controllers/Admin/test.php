<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Bill\Add;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\{
    Bill,
    BillCosponsor,
    BillPDF
};

use Carbon\Carbon;

class BillController extends Controller
{
    public function fetchAndSaveCongressData()
    {

        $apiKey = config('services.congress.api_key');

        try {
            // Fetch the list of congresses
            $response = Http::get('https://api.congress.gov/v3/congress', [
                'api_key' => $apiKey,
                'format' => 'json',
            ]);

            // Parse the response
            $congressList = $response->json()['congresses'];

            // Loop through each congress in the list
            foreach ($congressList as $congress) {
                // Extract the congress number from the name using regex
                preg_match('/\d+/', $congress['name'], $matches);
                $congressNumber = $matches[0] ?? null;

                if ($congressNumber) {
                    // Fetch the details for the specific congress
                    $detailsResponse = Http::get("https://api.congress.gov/v3/congress/{$congressNumber}", [
                        'api_key' => $apiKey,
                        'format' => 'json',
                    ]);

                    // Parse the details response
                    $congressDetails = $detailsResponse->json()['congress'];

                    // Save the relevant data to the Congress model
                    Congress::updateOrCreate(
                        [
                            'number' => $congressDetails['number'],
                        ],
                        [
                            'name' => $congressDetails['name'],
                            'startYear' => $congressDetails['startYear'],
                            'endYear' => $congressDetails['endYear'],
                        ]
                    );
                } else {
                    Log::warning('Congress number could not be extracted from name: ' . $congress['name']);
                }
            }

            Log::info('Congress data saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching Congress data: ' . $e->getMessage());
        }
    }

    public function createBills(Add $request)
    {
        $apiKey = config('services.congress.api_key');
        $congress = 118;
        $billType = 'hr';
        $fromDateTime = Carbon::parse('2024-01-01')->format('Y-m-d\T00:00:00\Z');
        $toDateTime = Carbon::parse('2024-06-30')->format('Y-m-d\T00:00:00\Z');
        $sort = 'updateDate+asc';
        $limit = 10;
        $offset = 0;

        try {
            do {
                // Construct the URL dynamically
                $url = "https://api.congress.gov/v3/bill/{$congress}/{$billType}";

                // Send the GET request with pagination parameters
                $response = Http::get($url, [
                    'fromDateTime' => $fromDateTime,
                    'toDateTime' => $toDateTime,
                    'sort' => $sort,
                    'limit' => $limit,
                    'offset' => $offset,
                    'api_key' => $apiKey,
                ]);

                // Parse the JSON response
                $data = $response->json();

                // Process each bill
                foreach ($data['bills'] as $bill) {
                    // Save the basic bill data
                    $savedBill = Bill::updateOrCreate(
                        [
                            'number' => $bill['number'],
                            'congress' => $bill['congress'],
                            'type' => $bill['type'],
                        ],
                        [
                            'originChamber' => $bill['originChamber'],
                            'originChamberCode' => $bill['originChamberCode'],
                            'url' => $bill['url'],
                            'title' => $bill['title'],
                            'latestActionDate' => $bill['latestAction']['actionDate'] ?? null,
                            'latestActionTime' => $bill['latestAction']['actionTime'] ?? null,
                            'latestActionText' => $bill['latestAction']['text'] ?? null,
                            'updateDate' => $bill['updateDate'],
                            'updateDateIncludingText' => isset($bill['updateDateIncludingText'])
                                ? Carbon::parse($bill['updateDateIncludingText'])->format('Y-m-d H:i:s')
                                : null,
                        ]
                    );

                    // Construct the cosponsors URL
                    $cosponsorsUrl = "https://api.congress.gov/v3/bill/{$congress}/{$billType}/{$bill['number']}/cosponsors?api_key={$apiKey}&format=json";

                    try {
                        // Fetch cosponsors data
                        $cosponsorsResponse = Http::get($cosponsorsUrl);
                        $cosponsorsData = $cosponsorsResponse->json();

                        // Log the cosponsors data
                        // Log::info($cosponsorsData);

                        // Save cosponsor data to the bill_cosponsors table
                        foreach ($cosponsorsData['cosponsors'] as $cosponsor) {
                            BillCosponsor::updateOrCreate(
                                [
                                    'bill_number' => $bill['number'], // Assuming you have a foreign key `bill_number`
                                    'bioguideId' => $cosponsor['bioguideId'],
                                ],
                                [
                                    'district' => $cosponsor['district'] ?? null,
                                    'firstName' => $cosponsor['firstName'],
                                    'fullName' => $cosponsor['fullName'],
                                    'isOriginalCosponsor' => $cosponsor['isOriginalCosponsor'],
                                    'lastName' => $cosponsor['lastName'],
                                    'party' => $cosponsor['party'],
                                    'sponsorshipDate' => $cosponsor['sponsorshipDate'],
                                    'state' => $cosponsor['state'],
                                    'url' => $cosponsor['url'],
                                ]
                            );
                        }
                    } catch (\Exception $e) {
                        Log::debug('Error fetching cosponsors data for bill ' . $bill['number'] . ': ' . $e->getMessage());
                    }
                }


                // Fetch additional data from the provided text URL with API key
                $textUrl = "https://api.congress.gov/v3/bill/{$congress}/{$billType}/{$bill['number']}/text?format=json&api_key={$apiKey}";

                try {
                    $textResponse = Http::get($textUrl);
                    $textData = $textResponse->json();

                    // Log the bill text data
                    Log::info($textData);

                    // Check if textVersions exist and save each one
                    // Check if textVersions exist
                    if (isset($textData['textVersions'])) {
                        foreach ($textData['textVersions'] as $version) {
                            $type = $version['type'] ?? null;

                            // Initialize URLs
                            $formattedTextUrl = null;
                            $pdfUrl = null;

                            // Process formats
                            foreach ($version['formats'] as $format) {
                                if ($format['type'] === 'Formatted Text') {
                                    $formattedTextUrl = $format['url'];
                                } elseif ($format['type'] === 'PDF') {
                                    $pdfUrl = $format['url'];
                                }
                            }

                            // Save the data to the BillPdf model
                            BillPdf::updateOrCreate(
                                [
                                    'bill_number' => $bill['number'], // Assuming this is a foreign key or identifier
                                    'type' => $type, // The type of the text version (e.g., 'Enrolled Bill')
                                ],
                                [
                                    'formatted_text_url' => $formattedTextUrl,
                                    'pdf_url' => $pdfUrl,
                                ]
                            );
                        }
                    }
                } catch (\Exception $e) {
                    Log::debug('Error fetching text data for bill ' . $bill['number'] . ': ' . $e->getMessage());
                }
                // Check if there is more data to fetch
                $count = count($data['bills'] ?? []);
                $offset += $count;
            } while ($count == $limit); // Continue fetching if the number of records is equal to the limit

        } catch (\Exception $e) {
            // Log any errors encountered during the request
            Log::debug('Error fetching data: ' . $e->getMessage());
        }
    }
    public function fetchCongressmember()
    {
        $apiKey = config('services.congress.api_key');
        $congress = 118;

        try {
            // Fetch the list of members for the specific Congress
            $response = Http::get("https://api.congress.gov/v3/member/congress/{$congress}", [
                'api_key' => $apiKey,
                'format' => 'json',
            ]);

            if ($response->successful()) {
                $members = $response->json()['members'];

                foreach ($members as $member) {
                    $bioguideId = $member['bioguideId'] ?? null;

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

                    // Prepare data for the members table
                    $memberData = [
                        'bioguideId' => $bioguideId,
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
                        'state' => $memberDetails['addressInformation']['district'] ?? null, // Assuming district is state
                    ];

                    // Save or update the member data
                    Member::updateOrCreate(
                        ['bioguideId' => $bioguideId],
                        $memberData
                    );

                    // Handle party history data
                    if (isset($memberDetails['partyHistory'])) {
                        foreach ($memberDetails['partyHistory'] as $history) {
                            $partyHistoryData = [
                                'bioguideId' => $bioguideId,
                                'partyAbbreviation' => $history['partyAbbreviation'] ?? null,
                                'partyName' => $history['partyName'] ?? null,
                                'partyStartYear' => $history['startYear'] ?? null,
                            ];

                            // Log the data before saving
                            Log::info('Saving party history data', ['data' => $partyHistoryData]);

                            // Save or update the party history data
                            MemberPartyHistory::updateOrCreate(
                                [
                                    'bioguideId' => $bioguideId,
                                    'partyAbbreviation' => $partyHistoryData['partyAbbreviation'],
                                    'partyStartYear' => $partyHistoryData['partyStartYear'],
                                ],
                                $partyHistoryData
                            );
                        }
                    }
                    // Fetch and save member terms data
                    if (isset($memberDetails['terms'])) {
                        foreach ($memberDetails['terms'] as $term) {
                            $termData = [
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
                                    'bioguideId' => $bioguideId,
                                    'congress' => $termData['congress'],
                                    'startYear' => $termData['startYear'],
                                ],
                                $termData
                            );
                        }
                    }
                }

                Log::info('All member details and party histories fetched and saved successfully.');
            } else {
                Log::error('Failed to fetch member list.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching member data: ' . $e->getMessage());
        }
    }
}
