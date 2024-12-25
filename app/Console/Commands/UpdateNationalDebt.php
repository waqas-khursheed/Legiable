<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NationalDebt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateNationalDebt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-national-debt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the national debt data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get National Debt data
            $debtResponse = Http::get('https://api.fiscaldata.treasury.gov/services/api/fiscal_service/v2/accounting/od/debt_to_penny', [
                'page[size]' => 1,
                'sort' => '-record_date'
            ]);

            // Check if the request was successful
            if ($debtResponse->successful()) {
                $debtData = $debtResponse->json();

                // Extract the latest debt data
                $latestDebt = $debtData['data'][0]['tot_pub_debt_out_amt'] ?? null;
                $debtRecordDate = $debtData['data'][0]['record_date'] ?? null;

                // Check if a record exists
                $nationalDebt = NationalDebt::first();

                if ($nationalDebt) {
                    // Update the existing record
                    $nationalDebt->amount = $latestDebt;
                    $nationalDebt->record_date = $debtRecordDate;
                    $nationalDebt->save();
                } else {
                    // Create a new record
                    NationalDebt::create([
                        'amount' => $latestDebt,
                        'record_date' => $debtRecordDate,
                    ]);
                }

                Log::info('National debt data updated successfully!');
            } else {
                Log::debug('Failed to fetch national debt data');
            }
        } catch (\Exception $e) {
            Log::debug('Error fetching data National debt : ' . json_encode($e->getMessage()));
        }
    }
}
