<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongressDetail extends Model
{
    use HasFactory;

    protected $table = 'congress_details';
    protected $fillable = [
        'title',
        'personal_detail',
        'additional_information',
    ];
}
