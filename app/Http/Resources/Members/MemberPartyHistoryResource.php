<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberPartyHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bioguideId' => $this->bioguideId,
            'partyAbbreviation' => $this->partyAbbreviation,
            'partyName' => $this->partyName,
            'partyStartYear' => $this->partyStartYear,
        ];
    }
}
