<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenateDetail extends Model
{
    use HasFactory;
    protected $table = 'senate_details';

    protected $fillable = [
        'title',
        'additional_information',
        'image',
    ];
}
