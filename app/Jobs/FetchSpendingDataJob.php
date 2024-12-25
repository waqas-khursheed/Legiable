<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BudgetFunction;

class FetchSpendingDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $fiscalYear;
    protected $period;
    /**
     * Create a new job instance.
     */
    public function __construct($type, $fiscalYear, $period)
    {
        $this->type = $type;
        $this->fiscalYear = $fiscalYear;
        $this->period = $period;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Construct the payload
        $payload = [
            'type' => $this->type,
            'filters' => [
                'fy' => $this->fiscalYear,
                'period' => $this->period
            ]
        ];

        // Make the HTTP POST request
        $response = Http::post('https://api.usaspending.gov/api/v2/spending/', $payload);

        if ($response->successful()) {
            $results = $response->json()['results'];

            foreach ($results as $result) {
                try {
                    // Use both 'code' and 'year' as the unique identifiers for updateOrCreate
                    BudgetFunction::updateOrCreate(
                        [
                            'code' => $result['code'],           // Unique identifier 1
                            'year' => $this->fiscalYear,         // Unique identifier 2
                        ],
                        [
                            'type' => $result['type'],
                            'name' => $result['name'],
                            'amount' => $result['amount'],
                        ]
                    );

                    Log::info('Budget Function Saved for Code: ' . $result['code'] . ' in year: ' . $this->fiscalYear);
                } catch (\Exception $e) {
                    Log::error('Failed to save Budget Function', [
                        'error' => $e->getMessage(),
                        'result' => $result
                    ]);
                }
            }
        } else {
            Log::error('API Request Failed', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
        }
    }
}
