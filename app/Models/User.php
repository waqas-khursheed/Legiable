<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'profile_image',
        'user_type',
        'address',
        'country_code',
        'country_iso_code',
        'country',
        'state',
        'city',
        'zip_code',
        'location',
        'latitude',
        'longitude',
        'date_of_birth',
        'gender',
        'about',
        'preferences',
        'member_preferences',
        'customer_id',
        'is_profile_complete',
        'social_type',
        'social_token',
        'device_type',
        'device_token',
        'is_social',
        'push_notification',
        'alert_notification',
        'is_forgot',
        'is_verified',
        'is_subscribed',
        'verified_code',
        'is_active',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getPreferencesAttribute()
    {
        return $this->attributes['preferences'] != null ? json_decode($this->attributes['preferences']) : [];
    }

    public function getMemberPreferencesAttribute()
    {
        return $this->attributes['member_preferences'] != null ? json_decode($this->attributes['member_preferences']) : [];
    }
    
    
    // public function scopeFilterProvider($query, $latitude, $longitude, $radius)
    // {
    //     return $query->selectRaw("users.id, users.full_name, users.profile_image,average_rating, users.address, users.latitude, users.longitude,
    //     ( 3956 * acos( cos( radians(?) ) *
    //     cos( radians( latitude ) )
    //     * cos( radians( longitude ) - radians(?)
    //     ) + sin( radians(?) ) *
    //     sin( radians( latitude ) ) )
    //     ) AS distance", [$latitude, $longitude, $latitude])
    //         ->having("distance", "<", $radius);
    // }
}
