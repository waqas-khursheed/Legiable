<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberTermResource extends JsonResource
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
            'chamber' => $this->chamber,
            'congress' => $this->congress,
            'district' => $this->district,
            'startYear' => $this->startYear,
            'endYear' => $this->endYear,
            'memberType' => $this->memberType,
            'stateCode' => $this->stateCode,
            'stateName' => $this->stateName,
        ];
    }
}
