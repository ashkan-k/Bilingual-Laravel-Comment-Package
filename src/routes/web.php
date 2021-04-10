<?php

use Ashkan\Comment\Controllers\CommentController;
use Ashkan\Comment\Controllers\LikeDisLikeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']] , function (){
    Route::resource('comments' , CommentController::class);
    Route::post('comments/answer/{parent_id}' , [CommentController::class , 'answer']);

    #######################################  Like And Dislike  ###########################################
    Route::post('comments/like_dislike/like' , [LikeDisLikeController::class , 'like']);
    Route::post('comments/like_dislike/dislike' , [LikeDisLikeController::class , 'dislike']);
    ######################################################################################################


    #######################################  Captcha  ###########################################
    Route::get('reload_captcha' , function (){
        return response()->json(['captcha'=> captcha_img()]);
    });
});
