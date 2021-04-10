<?php


namespace Ashkan\Comment\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [ "user_id", "commentable_id", "commentable_type", "content" , "title" , "parent_id"];

    public function getCreatedAtAttribute($value)
    {
        $time_zone = config('app.timezone');

        $persian_format = config('comment.DateTime_Format.Persian');
        $utc_format = config('comment.DateTime_Format.UTC');

        if ($time_zone == 'Asia/Tehran')
        {
            return Verta:: instance($value , $time_zone)->format($persian_format);
        }

        return Carbon:: parse($value , $time_zone)->format($utc_format);
    }

    ########################################################################

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('comment.commenter'));
    }

    public function likes_and_dislikes()
    {
        return $this->hasMany(Likes_And_DisLikes::class , 'comment_id');
    }

    public function answer()
    {
        return $this->belongsTo(Comment::class , 'id' , 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne(Comment::class , 'id' , 'parent_id');
    }
}
