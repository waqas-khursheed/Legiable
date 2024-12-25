<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Bills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // try {
        //     // Make the initial API request
        //     $response = Http::get('https://api.congress.gov/v3/summaries/117/hr', [
        //         'fromDateTime' => '2022-01-04T04:02:00Z',
        //         'toDateTime' => '2022-12-30T04:03:00Z',
        //         'sort' => 'updateDate asc',
        //         'api_key' => '2kjCweehWK6Q6wbBM39Ad9GMCZqRDNShOEzjru98', // Replace with your actual API key
        //     ]);

        //     // Parse the JSON response
        //     $data = $response->json();

        //     // Convert the entire response to JSON and save to a file
        //     Storage::put('api_response.json', json_encode($data, JSON_PRETTY_PRINT));

        //     // Access 'summaries' array from the response
        //     if (isset($data['summaries']) && is_array($data['summaries'])) {
        //         foreach ($data['summaries'] as $summary) {
        //             // Check if the 'bill' array and 'url' key exist
        //             if (isset($summary['bill']['url'])) {
        //                 $billUrl = $summary['bill']['url'];

        //                 // Log the bill URL
        //                 Log::info('Bill URL:', ['url' => $billUrl]);

        //                 // Save the URL and associated information to a file
        //                 $fileName = 'bill_urls/' . $summary['bill']['number'] . '.json';
        //                 Storage::put($fileName, json_encode($summary, JSON_PRETTY_PRINT));
        //             } else {
        //                 Log::warning('No URL found for bill', ['summary' => $summary]);
        //             }
        //         }
        //     } else {
        //         Log::warning('No summaries found in response', ['response' => $data]);
        //     }
        // } catch (\Exception $e) {
        //     Log::error('Error fetching data: ' . $e->getMessage());
        // }

        // try {
        //     $response = Http::get('https://api.congress.gov/v3/summaries/117/hr', [
        //         'fromDateTime' => '2022-01-04T04:02:00Z',
        //         'toDateTime' => '2022-12-30T04:03:00Z',
        //         'sort' => 'updateDate asc',
        //         'api_key' => '2kjCweehWK6Q6wbBM39Ad9GMCZqRDNShOEzjru98',
        //     ]);

        //     $data = $response->json(); // Parse the JSON response

        //     Log::info($data); // Log the response data

        // } catch (\Exception $e) {
        //     Log::debug('Error fetching data: ' . json_encode($e->getMessage()));
        // }

        // try {
        //     $apiKey = '2kjCweehWK6Q6wbBM39Ad9GMCZqRDNShOEzjru98'; // Fetch the API key from the .env file

        //     $response = Http::get('https://api.congress.gov/v3/bill/117/hr/4885', [
        //         'format' => 'json',
        //         'api_key' => $apiKey,
        //     ]);

        //     if ($response->successful()) {
        //         $data = $response->json(); // Parse the JSON response
        //         Log::info($data); // Log the response data
        //     } else {
        //         Log::error('Request failed: ' . $response->status());
        //     }

        // } catch (\Exception $e) {
        //     Log::debug('Error fetching data: ' . json_encode($e->getMessage()));
        // }

        // $apiKey = env('2kjCweehWK6Q6wbBM39Ad9GMCZqRDNShOEzjru98');
        // $congressNumber = '117'; // Example Congress number
        // $url = "https://api.congress.gov/v3/bills/$congressNumber";

        // Log::info('Starting FetchAndSaveBillsJob');

        // // Step 1: Make the API request
        // $response = Http::withHeaders([
        //     'X-API-Key' => '2kjCweehWK6Q6wbBM39Ad9GMCZqRDNShOEzjru98',
        // ])->get($url);
        // log::info($response);
    }
}
