<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpAndFeedBack extends Model
{
    use HasFactory;

    protected $table = 'help_and_feed_backs';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'images'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'full_name', 'profile_image');
    }
}
