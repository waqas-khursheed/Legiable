<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveBill extends Model
{
    use HasFactory;

    protected $table = 'save_bills';
    
    protected $fillable = [
        'user_id',
        'bill_id'
    ];
}
