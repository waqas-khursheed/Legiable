<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPartyHistory extends Model
{
    use HasFactory;

    protected $table = 'member_party_histories';

    protected $fillable = [
        'member_id',
        'bioguideId',
        'partyAbbreviation',
        'partyName',
        'partyStartYear',
    ];
}
