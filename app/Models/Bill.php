<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = [
        'congress',
        'type',
        'originChamber',
        'originChamberCode',
        'number',
        'url',
        'title',
        'latestActionDate',
        'latestActionTime',
        'latestActionText',
        'updateDate',
        'updateDateIncludingText'
    ];

    // public function bill_pdfs()
    // {
    //     return $this->hasMany(BillPDF::class, 'bill_number', 'number');
    // }

    // public function bill_cosponsor()
    // {
    //     return $this->hasMany(BillCosponsor::class, 'bill_number', 'number')
    //         ->whereColumn('congress', 'bill_cosponsors.congress');
    // }

    // public function bill_pdfs()
    // {
    //     return $this->hasMany(BillPDF::class, 'bill_number', 'number')
    //         ->whereColumn('congress', 'bill_p_d_f_s.congress');
    // }

    public function bill_cosponsor()
    {
        return $this->hasMany(BillCosponsor::class, 'bill_id', 'id');
    }

    public function bill_pdfs()
    {
        return $this->hasMany(BillPDF::class, 'bill_id', 'id');
    }
}
