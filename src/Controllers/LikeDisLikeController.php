<?php


namespace Ashkan\Comment\Controllers;


use App\Http\Controllers\Controller;
use Ashkan\Comment\Facades\CommentFacade;
use Ashkan\Comment\Facades\LikeDisLikeFacade;
use Ashkan\Comment\Models\Likes_And_DisLikes;
use Ashkan\Comment\Traits\Responses;
use Illuminate\Http\Request;

class LikeDisLikeController extends Controller
{
    use Responses;

    protected $liked;
    protected $dis_liked;

    private static function GetCommentByID($id)
    {
        $comment = CommentFacade::show($id);
        return $comment ? $comment->id : null;
    }

    private function SeparateExists($comment_id)
    {
        $items = LikeDisLikeFacade::GetExists($comment_id);
        foreach ($items as $item)
        {
            if ($item['type'] == 'like')
            {
                $this->liked = $item;
            }
            else
            {
                $this->dis_liked = $item;
            }
        }
    }

    ########################################################################################

    public function like(Request $request)
    {
        $comment_id = self::GetCommentByID($request['id']);
        $this->SeparateExists($comment_id);

        if ($this->liked)
        {
            $this->destroy($this->liked);
        }
        else
        {
            if ($this->dis_liked)
            {
                $this->destroy($this->dis_liked);
            }
            LikeDisLikeFacade::Like($comment_id);
        }

        return self::SuccessResponse('Your Costume Message');
    }

    public function dislike(Request $request)
    {
        $comment_id = self::GetCommentByID($request['id']);
        $this->SeparateExists($comment_id);

        if ($this->dis_liked)
        {
            $this->destroy($this->dis_liked);
        }
        else
        {
            if ($this->liked)
            {
                $this->destroy($this->liked);
            }
            LikeDisLikeFacade::DisLike($comment_id);
        }

        return self::SuccessResponse('Your Costume Message');
    }

    public function destroy(Likes_And_DisLikes $likes_And_DisLikes)
    {
        LikeDisLikeFacade::delete($likes_And_DisLikes);
    }
}
