<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'bill_pdfs' => BillPDFResource::collection($this->whenLoaded('bill_pdfs')),
        ];
    }
}
