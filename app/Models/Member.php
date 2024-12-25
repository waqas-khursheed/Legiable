<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'bioguideId',
        'partyName',
        'birthYear',
        'currentMember',
        'depiction_attribution',
        'depiction_imageUrl',
        'directOrderName',
        'firstName',
        'honorificName',
        'invertedOrderName',
        'lastName',
        'officialWebsiteUrl',
        'state',
    ];

    public function member_leaderships()
    {
        return $this->hasMany(MemberLeadership::class, 'member_id', 'id');
    }

    public function member_party_histories()
    {
        return $this->hasMany(MemberPartyHistory::class, 'member_id', 'id');
    }

    public function member_terms()
    {
        return $this->hasMany(MemberTerm::class, 'member_id', 'id');
    }
}
