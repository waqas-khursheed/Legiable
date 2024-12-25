<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congress extends Model
{
    use HasFactory;

    protected $table = 'congresses';

    protected $fillable = [
        'name',
        'startYear',
        'endYear',
        'number',
    ];
}
