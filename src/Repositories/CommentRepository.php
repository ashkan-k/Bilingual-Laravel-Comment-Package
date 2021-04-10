<?php


namespace Ashkan\Comment\Repositories;


use Ashkan\Comment\Models\Comment;

class CommentRepository
{
    private $pagination;

    public function __construct()
    {
        $this->pagination = config('comment.options.PaginationDefaultNumber');
    }

    public function ListDistinct($search = '')
    {
        if ($search != '')
        {
            return $this->ListDistinctWithSearch($search);
        }

        return $this->ListDistinctWithoutSearch();
    }

    public function ListDistinctWithPagination($search = '')
    {
        if ($search != '')
        {
            return $this->ListDistinctWithSearchWithPagination($search);
        }

        return $this->ListDistinctWithoutSearchWithPagination();
    }

    public function list_with_relations()
    {
        return Comment::with(['user' , 'commentable' , 'likes_and_dislikes' , 'answer' , 'parent' , 'answer.likes_and_dislikes' , 'answer.user'])->get();
    }

    public function show($id)
    {
        return Comment::find($id);
    }

    public function create($data , $model)
    {
        return Comment::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'commentable_type' => $model,
            'commentable_id' => $data['commentable_id'],
        ]);
    }

    public function CreateAnswer($data , $model)
    {
        return Comment::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'commentable_type' => $model,
            'commentable_id' => $data['commentable_id'],
            'parent_id' => $data['parent_id']
        ]);
    }

    public function update($comment , $data)
    {
        return $comment->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function delete(Comment $comment)
    {
        return $comment->delete();
    }

    ########################################################

    public function ListDistinctWithSearch($search)
    {
        return Comment::where(function ($query) use ($search){
                return $query->where('title' , 'like' , '%' . $search . '%')
                    ->Orwhere('content' , 'like' , '%' . $search . '%');
            })
            ->with(['user' , 'commentable' , 'likes_and_dislikes' , 'answer' , 'parent' , 'answer.likes_and_dislikes' , 'answer.user'])
            ->get();
    }

    public function ListDistinctWithoutSearch()
    {
        return Comment::where('parent_id' , '=' , null)
            ->with(['user' , 'commentable' , 'likes_and_dislikes' , 'answer' , 'parent' , 'answer.likes_and_dislikes' , 'answer.user'])
            ->get();
    }

    ########################################################

    public function ListDistinctWithSearchWithPagination($search)
    {
        return Comment::where(function ($query) use ($search){
                return $query->where('title' , 'like' , '%' . $search . '%')
                    ->Orwhere('content' , 'like' , '%' . $search . '%');
            })
            ->with(['user' , 'commentable' , 'likes_and_dislikes' , 'answer' , 'parent' , 'answer.likes_and_dislikes' , 'answer.user'])
            ->paginate($this->pagination);
    }

    public function ListDistinctWithoutSearchWithPagination()
    {
        return Comment::where('parent_id' , '=' , null)
            ->with(['user' , 'commentable' , 'likes_and_dislikes' , 'answer' , 'parent' , 'answer.likes_and_dislikes' , 'answer.user'])
            ->paginate($this->pagination);
    }
}
