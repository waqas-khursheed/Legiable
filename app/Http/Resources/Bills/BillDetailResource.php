<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SaveBill;

class BillDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'congress' => $this->congress,
            'type' => $this->type,
            'originChamber' => $this->originChamber,
            'originChamberCode' => $this->originChamberCode,
            'number' => $this->number,
            'title' => $this->title,
            'latestActionDate' => $this->latestActionDate,
            'updateDate' => $this->updateDate,
            'updateDateIncludingText' => $this->updateDateIncludingText,
            'is_save_bill' => $this->is_save_bill($this->id),
            'bill_pdfs' => BillPDFResource::collection($this->whenLoaded('bill_pdfs')),
            'bill_cosponsor' => BillCosponsorResource::collection($this->whenLoaded('bill_cosponsor')),
        ];
    }

    private function is_save_bill($id)
    {
        $save_bill = SaveBill::where(['user_id' => auth()->id(), 'bill_id' => $id])->first();
        if ($save_bill) {
            return 1;
        } else {
            return 0;
        }
    }
}
