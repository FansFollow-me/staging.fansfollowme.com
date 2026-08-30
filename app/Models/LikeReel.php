<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeReel extends Model
    protected $table = 'stg_like_reels';
{
    protected $fillable = ['user_id', 'reels_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reels()
    {
        return $this->belongsTo(Reel::class);
    }
}
