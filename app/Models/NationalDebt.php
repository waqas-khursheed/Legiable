<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalDebt extends Model
{
    use HasFactory;

    protected $table = 'national_debts';
    
    protected $fillable = [
        'amount',
        'record_date',
    ];
}
