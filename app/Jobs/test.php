<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExecutiveOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExecutiveOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $executive_id;
    protected $user_name;

    /**
     * Create a new job instance.
     */
    public function __construct($user_name, $executive_id)
    {
        $this->executive_id = $executive_id;
        $this->user_name = $user_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // joe-biden, donald-trump, barack-obama, george-w-bush, william-j-clinton
        // Log::info($this->user_name);

        try {
            $url = "https://www.federalregister.gov/api/v1/documents.json?per_page=20&conditions[president][]=$this->user_name";
            $executive_leader_id = $this->executive_id;
            do {
                // Make the API request
                $response = Http::get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    $documents = $data['results'];
                    $nextPageUrl = $data['next_page_url'];

                    // Loop through each document and save the data
                    foreach ($documents as $doc) {
                        // Prepare data for federal_register_documents table
                        $documentData = [
                            'executive_leader_id' => $executive_leader_id ?? null,
                            'title' => $doc['title'],
                            'type' => $doc['type'],
                            'document_number' => $doc['document_number'],
                            'html_url' => $doc['html_url'],
                            'pdf_url' => $doc['pdf_url'],
                            'public_inspection_pdf_url' => $doc['public_inspection_pdf_url'] ?? null,
                            'publication_date' => $doc['publication_date'],
                        ];

                        // Save or update the document in the database
                        $document = ExecutiveOrder::updateOrCreate(
                            ['document_number' => $doc['document_number']],
                            $documentData
                        );
                    }

                    // Update the URL for the next page of results
                    $url = $nextPageUrl;
                } else {
                    Log::error("Failed to fetch documents from Federal Register API. Status: " . $response->status());
                    break;
                }
            } while ($nextPageUrl); // Continue looping until next_page_url is null

            Log::info('All documents fetched and saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching documents: ' . $e->getMessage());
        }
    }
}
