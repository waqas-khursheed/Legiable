<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutiveLeader extends Model
{
    use HasFactory;

    protected $table = 'executive_leaders';
    
    protected $fillable = [
        'state', 
        'user_name',
        'first_name',
        'last_name',
        'party',
        'jurisdiction',
        'city',
        'committees',
        'birthday',
        'religion',
        'on_the_ballot',
        'birth_place',
        'home_city',
        'education',
        'contact_campaign_other',
        'campaign_website',
        'dc_contact',
        'dc_website',
        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'political_experience',
        'professional_experience',
        'military_experience',
        'other_experience',
        'other_facts',
    ];
}
