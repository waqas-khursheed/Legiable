<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyRight extends Model
{
    use HasFactory;
    protected $table = 'my_rights';
    protected $fillable = [
        'title',
        'text_definition',
        'simplefied',
    ];
}
