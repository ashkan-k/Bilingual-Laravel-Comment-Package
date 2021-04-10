<?php

if (!function_exists('getCommentableType')) {

    function getCommentableType($model)
    {
        return str_replace('/' , '\\' , $model);
    }
}
