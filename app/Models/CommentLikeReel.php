<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLikeReel extends Model
    protected $table = 'stg_comment_like_reels';
{
    protected $fillable = ['user_id', 'comment_reels_id', 'reel_replies_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReel()
    {
        return $this->belongsTo(CommentReel::class);
    }

    public function reelReply()
    {
        return $this->belongsTo(ReelReply::class);
    }
}
