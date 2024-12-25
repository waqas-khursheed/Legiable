<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeRepresentative extends Model
{
    use HasFactory;

    protected $table = 'like_representatives';

    protected $fillable = [
        'user_id',
        'member_id',
        'is_like',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
