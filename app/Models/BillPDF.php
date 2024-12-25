<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPDF extends Model
{
    use HasFactory;

    protected $table = 'bill_p_d_f_s';

    protected $fillable = [
        'bill_id',
        'congress',
        'bill_number',
        'type',
        'formatted_text_url',
        'pdf_url',
    ];
}
