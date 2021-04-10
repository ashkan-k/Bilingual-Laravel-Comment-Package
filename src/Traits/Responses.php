<?php


namespace Ashkan\Comment\Traits;


trait Responses
{
    public static function SuccessResponse($message)
    {
        return response()->json(['message' => $message , 'status' => 'OK'], 200);
    }

    public static function FailResponse($error)
    {
        return response()->json(['error' => $error , 'status' => 'FAIL'], 200);
    }

    public static function CommentsResponse($comments)
    {
        return response()->json(['comments' =>  $comments, 'status' => 'OK'] , 200);
    }
}
