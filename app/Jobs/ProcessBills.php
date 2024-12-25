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
    Bill,
    BillCosponsor,
    BillPDF
};
use Carbon\Carbon;

class ProcessBills implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $congress;
    protected $billType;

    protected $limit;
    /**
     * Create a new job instance.
     */
    public function __construct($congress, $billType,  $limit)
    {
        $this->congress = $congress;
        $this->billType = $billType;
  
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = config('services.congress.api_key');
        $offset = 0;

        try {
            do {
                // Construct the URL dynamically
                $url = "https://api.congress.gov/v3/bill/{$this->congress}/{$this->billType}";

                // Send the GET request with pagination parameters
                $response = Http::get($url, [
                    // 'fromDateTime' => $this->fromDateTime,
                    // 'toDateTime' => $this->toDateTime,
                    // 'sort' => 'updateDate+asc',
                    'limit' => $this->limit,
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
                    // Get the ID of the saved Bill
                    $billId = $savedBill->id;

                    // Construct the cosponsors URL
                    $cosponsorsUrl = "https://api.congress.gov/v3/bill/{$this->congress}/{$this->billType}/{$bill['number']}/cosponsors?api_key={$apiKey}&format=json";

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
                                    'bill_id' => $billId, 
                                    'bioguideId' => $cosponsor['bioguideId'],
                                    
                                ],
                                [
                                    'bill_number' => $bill['number'],
                                    'congress' => $bill['congress'],
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

                    // Fetch additional data from the text URL with API key
                    $textUrl = "https://api.congress.gov/v3/bill/{$this->congress}/{$this->billType}/{$bill['number']}/text?format=json&api_key={$apiKey}";

                    try {
                        $textResponse = Http::get($textUrl);
                        $textData = $textResponse->json();

                        // Log the bill text data
                        // Log::info($textData);

                        // Check if textVersions exist and save each one
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
                                        'bill_id' => $billId, // Use the bill's ID
                                        'type' => $type,
                                    ],
                                    [
                                        'bill_number' => $bill['number'],
                                        'congress' => $bill['congress'],
                                        'formatted_text_url' => $formattedTextUrl,
                                        'pdf_url' => $pdfUrl,
                                    ]
                                );
                            }
                        }
                    } catch (\Exception $e) {
                        Log::debug('Error fetching text data for bill ' . $bill['number'] . ': ' . $e->getMessage());
                    }
                }

                // Check if there is more data to fetch
                $count = count($data['bills'] ?? []);
                $offset += $count;
            } while ($count == $this->limit); // Continue fetching if the number of records is equal to the limit

        } catch (\Exception $e) {
            // Log any errors encountered during the request
            Log::debug('Error fetching data: ' . $e->getMessage());
        }
    }
}
