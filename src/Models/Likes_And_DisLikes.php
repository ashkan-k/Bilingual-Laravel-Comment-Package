<?php


namespace Ashkan\Comment\Models;


use Illuminate\Database\Eloquent\Model;

class Likes_And_DisLikes extends Model
{
    protected $table = 'likes_and_dislikes';

    protected $fillable = ['user_id' , 'comment_id' , 'type'];

    public function user()
    {
        return $this->belongsTo(config('comment.commenter'));
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
