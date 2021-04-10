<?php


namespace Ashkan\Comment\Repositories;

use Ashkan\Comment\Models\Likes_And_DisLikes;

class LikeDisLikeRepository
{
    public function Like($comment_id)
    {
        return Likes_And_DisLikes::create([
            'comment_id' => $comment_id,
            'user_id' => auth()->user()->id,
            'type' => 'like'
        ]);
    }

    public function DisLike($comment_id)
    {
        return Likes_And_DisLikes::create([
            'comment_id' => $comment_id,
            'user_id' => auth()->user()->id,
            'type' => 'dislike'
        ]);
    }

    public function GetExists($id)
    {
        return Likes_And_DisLikes::where(function ($query) use ($id){
            return $query->where('comment_id' , $id)
                ->where('user_id' , auth()->user()->id);

        })->get();
    }

    public function delete($likes_And_DisLikes)
    {
        return $likes_And_DisLikes->delete();
    }
}
