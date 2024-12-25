<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberLeadershipResource extends JsonResource
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
            'congress' => $this->congress,
            'type' => $this->type,
        ];
    }
}
