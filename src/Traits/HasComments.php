<?php


namespace Ashkan\Comment\Traits;

use Ashkan\Comment\Models\Comment;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }
}
