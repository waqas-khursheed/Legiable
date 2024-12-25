<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveExecutive extends Model
{
    use HasFactory;

    protected $table = 'save_executives';

    protected $fillable = [
        'user_id',
        'executive_id'
    ];
}
