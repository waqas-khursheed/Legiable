<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseDetail extends Model
{
    use HasFactory;

    protected $table = 'house_details';

    protected $fillable = [
        'title',
        'additional_information',
        'image',
    ];
}
