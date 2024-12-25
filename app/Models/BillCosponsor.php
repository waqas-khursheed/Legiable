<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillCosponsor extends Model
{
    use HasFactory;

    protected $table = 'bill_cosponsors';

    protected $fillable = [
        'bill_id',
        'congress',
        'bill_number',
        'bioguideId',
        'district',
        'firstName',
        'fullName',
        'isOriginalCosponsor',
        'lastName',
        'party',
        'sponsorshipDate',
        'state',
    ];
}
