<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExecutiveLeaderResource extends JsonResource
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
            'state' => $this->state,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'party' => $this->party,
            'jurisdiction' => $this->jurisdiction,
            'city' => $this->city,
            'committees' => $this->committees,
            'birthday' => $this->birthday,
            'religion' => $this->religion,
            'on_the_ballot' => $this->on_the_ballot,
            'birth_place' => $this->birth_place,
            'home_city' => $this->home_city,
            'education' => $this->education,
            'contact_campaign_other' => $this->contact_campaign_other,
            'campaign_website' => $this->campaign_website,
            'dc_contact' => $this->dc_contact,
            'dc_website' => $this->dc_website,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'youtube' =>  $this->youtube,
            'political_experience' => $this->political_experience,
            'professional_experience' => $this->professional_experience,
            'military_experience' =>  $this->military_experience,
            'other_experience' =>  $this->other_experience,
            'other_facts' =>  $this->other_facts,
        ];
    }
}
