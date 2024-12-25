<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SaveRepresentative;
use App\Models\LikeRepresentative;

class MemberDetailResource extends JsonResource
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
            'honorificName' => $this->honorificName,
            'invertedOrderName' => $this->invertedOrderName,
            'lastName' => $this->lastName,
            'state' => $this->state,
            'is_save_member' => $this->is_save_member($this->id),
            'is_like_member' => $this->is_like_member($this->id),
            'member_leaderships' => MemberLeadershipResource::collection($this->whenLoaded('member_leaderships')),
            'member_party_histories' => MemberPartyHistoryResource::collection($this->whenLoaded('member_party_histories')),
            'member_terms' => MemberTermResource::collection($this->whenLoaded('member_terms')),
        ];
    }

    private function is_save_member($id)
    {
        $save_member = SaveRepresentative::where(['user_id' => auth()->id(), 'member_id' => $id])->first();
        if ($save_member) {
            return 1;
        } else {
            return 0;
        }
    }

    private function is_like_member($id)
    {
        $like_member = LikeRepresentative::where(['user_id' => auth()->id(), 'member_id' => $id])->first();
        if ($like_member) {
            if ($like_member->is_like == '1') {
                return "like";
            } elseif ($like_member->is_like == '0') {
                return "dislike";
            }
        }
        return null;
    }
}
