<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTerm extends Model
{
    use HasFactory;

    protected $table = 'member_terms';

    protected $fillable = [
        'member_id',
        'bioguideId',
        'chamber',
        'congress',
        'district',
        'startYear',
        'endYear',
        'memberType',
        'stateCode',
        'stateName',
    ];
}
