<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'profile_image' => $this->profile_image,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'address' => $this->address,
            'country_code' => $this->country_code,
            'country_iso_code' => $this->country_iso_code,
            'zip_code' => $this->zip_code,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'gender' => $this->gender,
            'about' => $this->about,
            'preferences' => $this->preferences,
            'member_preferences' => $this->member_preferences,
            'device_token' => $this->device_token,
            'user_type' => $this->user_type,
            'social_type' => $this->social_type,
            'is_profile_complete' =>  $this->is_profile_complete,
            'push_notification' => $this->push_notification,
            'alert_notification' => $this->alert_notification,
            'is_verified' =>  $this->is_verified,
            'is_active' =>  $this->is_active,
            'is_social' =>  $this->is_social,
        ];
    }
}
