<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillCosponsorResource extends JsonResource
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
            'bill_number' => $this->bill_number,
            'bioguideId' => $this->bioguideId,
            'district' => $this->district,
            'firstName' => $this->firstName,
            'fullName' => $this->fullName,
            'isOriginalCosponsor' => $this->isOriginalCosponsor,
            'lastName' => $this->lastName,
            'party' => $this->party,
            'sponsorshipDate' => $this->sponsorshipDate,
            'state' => $this->state,
            'url' => $this->url,
        ];
    }
}
