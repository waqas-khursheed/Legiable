<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveMyRight extends Model
{
    use HasFactory;

    protected $table = 'save_my_rights';

    protected $fillable = [
        'user_id',
        'my_right_id'
    ];
}
