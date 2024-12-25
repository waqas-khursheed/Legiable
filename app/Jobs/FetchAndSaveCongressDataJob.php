<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Congress;

class FetchAndSaveCongressDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
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
}
