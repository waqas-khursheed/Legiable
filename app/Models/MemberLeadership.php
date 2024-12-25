<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLeadership extends Model
{
    use HasFactory;
    protected $table = 'member_leaderships';

    protected $fillable = [
        'member_id',
        'bioguideId',
        'congress',
        'type',
    ];
}
