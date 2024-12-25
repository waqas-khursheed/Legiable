<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeExecutive extends Model
{
    use HasFactory;
    protected $table = 'like_executives';

    protected $fillable = [
        'user_id',
        'executive_id',
        'state',
        'is_like',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
