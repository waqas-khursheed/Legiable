<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteHouseDetail extends Model
{
    use HasFactory;

    protected $table = 'white_house_details';
    protected $fillable = [
        'title',
        'personal_detail',
        'additional_information',
    ];
}
