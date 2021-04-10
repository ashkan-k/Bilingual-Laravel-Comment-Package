<?php


namespace Ashkan\Comment\Facades;

use Illuminate\Support\Facades\Facade;

class LikeDisLikeFacade extends Facade
{
        protected static function getFacadeAccessor()
        {
            return 'Like_DisLIek';
        }
}
