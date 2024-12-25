<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutiveOrder extends Model
{
    use HasFactory;

    protected $table = 'executive_orders';

    protected $fillable = [
        'executive_leader_id',
        'title',
        'type',
        'document_number',
        'html_url',
        'pdf_url',
        'public_inspection_pdf_url',
        'publication_date',
    ];
}
