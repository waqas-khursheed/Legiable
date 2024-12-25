<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetFunction extends Model
{
    use HasFactory;

    protected $table = 'budget_functions';

    protected $fillable = [
        'code',
        'type',
        'name',
        'amount',
        'year'
    ];
}
