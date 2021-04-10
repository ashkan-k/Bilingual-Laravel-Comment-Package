<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    |  Default Configs
    |--------------------------------------------------------------------------
    |
    | This are simple and basic configs of comment package.
    | there are required and you can change theme in your favorite
    |
    */

    'Base_Url' => '',

    'commenter' => User::class,

    'DateTime_Format' => [
        'UTC' => 'Y m , F',
        'Persian' => '%B %d، %Y'
    ],

    'font' => '/assets/fonts.css',

    'Default_Image' => '/assets/profile.png',


    /*
    |--------------------------------------------------------------------------
    |  More Options
    |--------------------------------------------------------------------------
    |
    | This are more and advance options of comment package.
    | there are required and you can change theme in your favorite
    | they are so useful in package and can make your comment part more professional
    |
    */

    'options' => [
           /*
           |--------------------------------------------------------------------------
           |  Pagination Options
           |--------------------------------------------------------------------------
           |
           | 1  => 'Material Icons' (Default)
           | 2 => 'Bootstrap'
           | 3 => 'Without Pagination'
           |
           */
        'Pagination' => 1,
        'PaginationDefaultNumber' => 8,


           /*
           |--------------------------------------------------------------------------
           |  Editor Options
           |--------------------------------------------------------------------------
           |
           | 1 => 'CKEDITOR' (Default)
           | 2 => 'Tiny MCE'
           | 3 => 'Without Editor' ( simple textarea )
           |
           */
        'Editor' => 1,

        'Captcha' => true,

        'SearchBox' => true,

        'Commenter Display Name Field' => 'name',

        'Has_Like_And_DisLike' => true,
        'Has_Reply' => true,
        'Has_Edit' => true,

        'ALLOW_ANONYMOUS_Comment' => false,
        'Allow_Delete_Comment' => true,

        'Loading' => true,
    ]

];
