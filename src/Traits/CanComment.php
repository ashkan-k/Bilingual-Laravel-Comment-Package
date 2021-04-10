<?php


namespace Ashkan\Comment\Traits;


use App\Models\User;
use Ashkan\Comment\Models\Comment;
use Ashkan\Comment\Models\Likes_And_DisLikes;

trait CanComment
{
    public function comments()
    {
        return $this->hasMany(Comment::class , 'user_id');
    }

    public function likes_and_dislikes()
    {
        return $this->hasMany(Likes_And_DisLikes::class , 'comment_id');
    }
}
