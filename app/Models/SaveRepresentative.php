<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveRepresentative extends Model
{
    use HasFactory;

    protected $table = 'save_representatives';

    protected $fillable = [
        'user_id',
        'member_id'
    ];
}
