<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfRight extends Model
{
    use HasFactory;

    protected $table = 'bill_of_rights';

    protected $fillable = [
        'title',
        'personal_detail',
        'additional_information',
    ];
}
