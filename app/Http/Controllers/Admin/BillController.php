<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Bill\Add;
use App\Http\Requests\Member\AddMember;
use App\Http\Requests\Spending\SpendingData;
use App\Http\Requests\Executive\Orders;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\{
    Bill,
    BillCosponsor,
    BillPDF,
    Congress,
    Member,
    MemberPartyHistory,
    MemberTerm,
    ExecutiveOrder,
    NationalDebt,
    ExecutiveLeader,
};
use App\Jobs\ProcessBills;
use Carbon\Carbon;
use App\Jobs\FetchAndSaveCongressDataJob;
use App\Jobs\ProcessCongressMembers;
use App\Jobs\ExecutiveOrderJob;
use App\Jobs\FetchSpendingDataJob;

class BillController extends Controller
{

    // Fetch Congress
    public function fetchAndSaveCongressData()
    {
        FetchAndSaveCongressDataJob::dispatch();
    }


    /****************** Congress Bills ****************/
    public function congressBills()
    {
        $congresses = Congress::all();
        return view("admin.jobs.bills", compact('congresses'));
    }

    public function createBills(Add $request)
    {
        // dd($request->all());
        ProcessBills::dispatch(
            $request->congress, // Congress number
            $request->bill_type, // Bill type  :The type of bill. Value can be hr, s, hjres, sjres, hconres, sconres, hres, or sres.
            250 // Limit
        );

        return response()->json(["success" => "Bills processing has been started"]);

        // ProcessBills::dispatch(
        //     118, // Congress number
        //     'hr', // Bill type  :The type of bill. Value can be hr, s, hjres, sjres, hconres, sconres, hres, or sres.
        //     Carbon::parse('2024-01-01')->format('Y-m-d\T00:00:00\Z'), // From date
        //     Carbon::parse('2024-06-30')->format('Y-m-d\T00:00:00\Z'), // To date
        //     250 // Limit
        // );
    }


    /****************** Congress Member ****************/
    public function congressmember()
    {
        $congresses = Congress::all();
        return view("admin.jobs.member", compact('congresses'));
    }
    public function fetchCongressmember(AddMember $request)
    {
        $congress = $request->congress;
        $limit = 50; // Number of records per page
        $offset = 0; // Starting offset
        ProcessCongressMembers::dispatch($congress, $limit, $offset);

        return response()->json(["success" => "Member processing has been started"]);
    }


    /****************** Executive Orders ****************/
    public function executiveOrders()
    {
        $executives = ExecutiveLeader::where('user_name', "!=", null)->get(['id', 'user_name', 'first_name', 'last_name']);
        return view("admin.jobs.executive_orders", compact('executives'));
    }
    public function fetchExecutiveOrders(Orders $request)
    {
        $executive_id = $request->executive_id;
        $user_name = $request->user_name;

        ExecutiveOrderJob::dispatch($executive_id, $user_name);

        return response()->json(["success" => "Executive orders processing has been started"]);
    }


    /****************** National Debt And Budget ****************/
    public function nationalDebtAndBudget()
    {
        return view("admin.jobs.national-debt");
    }
    public function getNationalDebtAndBudget(Request $request)
    {
        $year = $request->record_year;
        return   $this->getNationalDebtForDate($year); // Fetch debt for December 31 of each year

    }

    private function getNationalDebtForDate($date)
    {
        $debtResponse = Http::get('https://api.fiscaldata.treasury.gov/services/api/fiscal_service/v2/accounting/od/debt_to_penny', [
            'filter' => 'record_date:eq:' . $date,
            'sort' => '-record_date',
            'page[size]' => 1
        ]);

        if ($debtResponse->successful()) {
            $debtData = $debtResponse->json();

            if (!empty($debtData['data'])) {
                $latestDebt = $debtData['data'][0]['tot_pub_debt_out_amt'] ?? null;
                $debtRecordDate = $debtData['data'][0]['record_date'] ?? null;

                // Get the year from the record date
                $recordYear = date('Y', strtotime($debtRecordDate));

                // Check if a record exists for the year
                $nationalDebt = NationalDebt::whereYear('record_date', $recordYear)->first();
                if ($nationalDebt) {
                    // Update the existing record
                    $nationalDebt->amount = $latestDebt;
                    $nationalDebt->record_date = $debtRecordDate;

                    $nationalDebt->save();
                    return response()->json(["success" => "National debt updated Successfully"]);
                } else {
                    // Create a new record
                    NationalDebt::create([
                        'amount' => $latestDebt,
                        'record_date' => $debtRecordDate,
                    ]);
                    return response()->json(["success" => "National debt save Successfully"]);
                }
            } else {
                return response()->json(['error' => 'No debt data found'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to fetch national debt data'], 500);
        }
    }


    /****************** Spending Data Budget Function****************/
    public function spendingData()
    {
        return view("admin.jobs.spending");
    }

    public function getSpendingData(SpendingData $request)
    {
        $requestYear = $request->fiscal_year;
        $currentYear = date('Y');

        if ($currentYear == $requestYear) {
            $fiscalYear = $request->input('fy', date('Y'));
            $period = $request->input('period', date('n'));
        } else {
            $fiscalYear = $request->input('fy', $requestYear);
            $period = $request->input('period', '12');
        }

        $type = $request->input('type', 'budget_function');

        FetchSpendingDataJob::dispatch($type, $fiscalYear, $period);

        return response()->json(["success" => "Spending data processing has been started"]);
    }
}
