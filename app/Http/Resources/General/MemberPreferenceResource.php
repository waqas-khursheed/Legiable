<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MemberTerm;
class MemberPreferenceResource extends JsonResource
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
            'bioguideId' => $this->bioguideId,
            'birthYear' => $this->birthYear,
            'currentMember' => $this->currentMember,
            'depiction_attribution' => $this->depiction_attribution,
            'depiction_imageUrl' => $this->depiction_imageUrl,
            'directOrderName' => $this->directOrderName,
            'firstName' => $this->firstName,
            'invertedOrderName' => $this->invertedOrderName,
            'lastName' => $this->lastName,
            'officialWebsiteUrl' => $this->officialWebsiteUrl,
            'state' => $this->state,
            'member_term' => $this->member_term($this->bioguideId),
        ];
    }

    private function member_term($bioguideId)
    {
        return MemberTerm::where(['bioguideId' => $bioguideId])->orderBy('startYear', 'DESC')->first(['chamber', 'congress', 'memberType']);
    }
}
