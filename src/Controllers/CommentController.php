<?php


namespace Ashkan\Comment\Controllers;


use App\Http\Controllers\Controller;
use Ashkan\Comment\Facades\CommentFacade;
use Ashkan\Comment\Models\Comment;
use Ashkan\Comment\Traits\CommentValidation;
use Ashkan\Comment\Traits\Responses;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use CommentValidation , Responses;

    private $Allow_Pagination;

    public function __construct()
    {
        $this->Allow_Pagination = config('comment.options.Pagination');
    }

    public function GetAllWithRelations()
    {
        $comments = CommentFacade::list_with_relations();
        return response()->json(['comments' => $comments] , 200);
    }

    #############################################################################

    public function index()
    {
        $search = \request('search') ?: '';

        if ($this->Allow_Pagination == 1 || $this->Allow_Pagination == 2)
        {
            $comments = CommentFacade::ListDistinctWithPagination($search);
        }
        else
        {
            $comments['data'] = CommentFacade::ListDistinct($search);
        }

        return self::CommentsResponse($comments);
    }

    public function store(Request $request)
    {
        $data = self::DecodeData($request);

        if ($error = self::Validation($data , $request->method()))
        {
            return $error;
        }

        $model_type = getCommentableType($data['model']);
        CommentFacade::create($data, $model_type);

        return self::SuccessResponse(__('comment.Dear User , Your Comment has been successfully sent'));
    }

    public function answer(Request $request)
    {
        $data = self::DecodeData($request);

        if ($error = self::Validation($data , $request->method()))
        {
            return $error;
        }

        $model_type = getCommentableType($data['model']);
        CommentFacade::CreateAnswer($data, $model_type);

        return self::SuccessResponse(__('comment.Dear User , Your Answer to this comment has been successfully sent'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = self::DecodeData($request);

        if ($error = self::Validation($data , $request->method()))
        {
            return $error;
        }

        CommentFacade::update($comment , $data);

        return self::SuccessResponse(__('comment.Dear User , Your Comment has been successfully updated'));
    }

    public function destroy(Comment $comment)
    {
        CommentFacade::delete($comment);
        return self::SuccessResponse(__('comment.Dear User , Your Comment has been successfully deleted'));
    }

    ####################################################################################

    private static function DecodeData($request)
    {
        $title = json_decode($request['title'], true);
        $content = json_decode($request['content'], true);
        $captcha = json_decode($request['captcha'], true);
        $model = json_decode($request['model'], FALSE);
        $commentable_id = json_decode($request['commentable_id'], true);
        $parent_id = json_decode($request['parent_id'], true);

        return [
            'title' => $title, 'content' => $content, 'model' => $model,
            'commentable_id' => $commentable_id, 'parent_id' => $parent_id,
            'captcha' => $captcha
        ];
    }
}
