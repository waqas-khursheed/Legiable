<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\Bills;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Bills\BillResource;
use App\Http\Resources\Bills\BillDetailResource;
use Illuminate\Validation\Rule;

use App\Models\{
    Bill,
    SaveBill,
    BillCosponsor,
    ExecutiveOrder
};
use App\Traits\ApiResponser;

class CongressBillController extends Controller
{
    use ApiResponser;

    // Get Bills
    public function getCongressBill(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $bills = Bill::with(['bill_pdfs'])->skip($request->offset)
            ->take(10)
            ->get();

        if (count($bills) > 0) {
            $data = BillResource::collection($bills);
            return $this->successDataResponse('Bill found successfully', $data, 200);
        } else {
            return $this->errorResponse('Bill not found.', 400);
        }
    }

    // Bill Detail 
    public function getCongressBillDetail(Request $request)
    {
        $this->validate($request, [
            'bill_id' => 'required|exists:bills,id',
        ]);

        try {
            $billDetail = Bill::with(['bill_pdfs', 'bill_cosponsor'])
                ->where('id', $request->bill_id)
                ->first();
            if ($billDetail) {
                $data = new BillDetailResource($billDetail);
                return $this->successDataResponse('Bill detail found successfully', $data, 200);
            } else {
                return $this->errorResponse('Bill detail not found.', 400);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Bill Saved List
    public function billSaveRemove(Request $request)
    {
        $this->validate($request, [
            'bill_id' => 'required|exists:bills,id',
        ]);

        $authId = auth()->user()->id;

        try {

            $saveExists = SaveBill::where(['user_id' => $authId, 'bill_id' => $request->bill_id])->first();

            if (!empty($saveExists)) {
                $saveExists->delete();
                return $this->successResponse('Removed bill.');
            } else {
                SaveBill::create([
                    'user_id' => $authId,
                    'bill_id'   => $request->bill_id
                ]);

                return $this->successResponse('Saved bill successfully.');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function BillSaveList(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $authId = auth()->user()->id;

        $savedIds = SaveBill::where('user_id', $authId)->pluck('bill_id');

        $bills = Bill::with(['bill_pdfs'])->whereIn('id', $savedIds)->skip($request->offset)
            ->take(10)->get();
        if (count($bills) > 0) {
            $data = BillResource::collection($bills);
            return $this->successDataResponse('Saved bill found successfully', $data, 200);
        } else {
            return $this->errorResponse('bill not found.', 400);
        }
    }

    // Filter Bills
    public function filterBill(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
            'chamber_type' => ['nullable', Rule::requiredIf($request->has('chamber_type')), 'in:House,Senate'],
            'bill_type' => ['nullable', Rule::requiredIf($request->has('bill_type'))],
            'member_bioguideId' => ['nullable', Rule::requiredIf($request->has('member_bioguideId'))],
        ]);

        try {
            $billIds = BillCosponsor::where('bioguideId', $request->member_bioguideId)->pluck('bill_id');

            $bills = bill::when($request->has('chamber_type'), function ($query) use ($request) {
                return $query->where('originChamber', $request->chamber_type);
            })->when($request->has('bill_type'), function ($query) use ($request) {
                return $query->where('type', $request->bill_type);
            })->when($request->has('member_bioguideId'), function ($query) use ($billIds) {
                return $query->whereIn('id', $billIds);
            })->skip($request->offset)->take(10)->get();

            if (count($bills) > 0) {
                $data = BillResource::collection($bills);
                return $this->successDataResponse('Bill found successfully', $data, 200);
            } else {
                return $this->errorResponse('Bill not found.', 400);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Filter Bill By Title
    public function filterBillTitle(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
            'search_text' => 'required',
        ]);

        $bills = Bill::where('title', 'LIKE', '%' . $request->search_text . '%')
            ->skip($request->offset)->take(10)->get();

        if (count($bills) > 0) {
            $data = BillResource::collection($bills);
            return $this->successDataResponse('Filter bill found successfully', $data, 200);
        } else {
            return $this->errorResponse('Filter bill not found.', 400);
        }
    }

    // Bill Types
    public function billTypes()
    {
        $billType = Bill::groupBy('type')->pluck('type');

        if (count($billType) > 0) {
            return $this->successDataResponse('Bill type found successfully', $billType, 200);
        } else {
            return $this->errorResponse('Bill type not found.', 400);
        }
    }

    public function executiveOrders(Request $request)
    {
        $this->validate($request, [
            'executive_leader_id' => 'required|exists:executive_orders,id',
            'offset' => 'required|numeric',
        ]);

        $executiveOrder = ExecutiveOrder::where('executive_leader_id', $request->executive_leader_id)
            ->orderBy('publication_date', 'DESC')
            ->skip($request->offset)->take(10)->get();

        if (count($executiveOrder) > 0) {
            return $this->successDataResponse('Executive order found successfully', $executiveOrder, 200);
        } else {
            return $this->errorResponse('Executive order not found.', 400);
        }
    }
}
