<?php


namespace Ashkan\Comment;

use Ashkan\Comment\Repositories\CommentRepository;
use Ashkan\Comment\Repositories\LikeDisLikeRepository;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('comments' , function (){
           return new CommentRepository();
        });

        $this->app->singleton('Like_DisLIek' , function (){
            return new LikeDisLikeRepository();
        });

        ## Load Configs ##
        $this->mergeConfigFrom(__DIR__ . '/config/comment.php' , 'comment');
    }

    public function boot()
    {
        ## Load Requirements ##
        $this->loadMigrationsFrom(__DIR__ . '\Migrations');
        $this->loadRoutesFrom(__DIR__ . '\routes\web.php');
        $this->loadViewsFrom(__DIR__ . '\views' , 'comment');

        ## Helper Functions ##
        require __DIR__ . '\helpers\comment.php';

        ## Publishes ##
        $this->publishes([
            __DIR__ . '/config/comment.php' => config_path('comment.php'),
            __DIR__ . '/config/captcha.php' => config_path('captcha.php'),
            __DIR__ . '/Migrations' => database_path('migrations'),
            __DIR__ . '/Models' => app_path('Models'),
            __DIR__ . '/lang/en/comment.php' => base_path('resources/lang/en/comment.php'),
            __DIR__ . '/lang/fa/comment.php' => base_path('resources/lang/fa/comment.php'),
            __DIR__ . '/assets' => public_path('assets'),
            __DIR__ . '/views' => base_path('resources/views/comment')
        ]);
    }
}
