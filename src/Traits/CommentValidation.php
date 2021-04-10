<?php


namespace Ashkan\Comment\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait CommentValidation
{
    use Responses;

    private static $rules = [
        'title' => 'required|max:70',
        'content' => 'required',
    ];

    public function Validation($data , $method)
    {
        if ($method == 'POST')
        {
            self::$rules['commentable_id'] =  'required|integer';
            self::$rules['model'] = 'required';
        }

        if (config('comment.options.Captcha'))
        {
            self::$rules['captcha'] = 'required|captcha';
        }

        $validator = Validator::make($data, self::$rules, [
            'title.required' => __('comment.validations.required' , ['field' => __('comment.title')]),
            'content.required' => __('comment.validations.required' , ['field' => __('comment.content')]),
            'commentable_id.required' => __('comment.validations.required' , ['field' => __('comment.commentable_id')]),
            'model.required' => __('comment.validations.required' , ['field' => __('comment.model')]),

            'captcha.required' => __('comment.validations.required' , ['field' => __('comment.captcha')]),
            'captcha.captcha' => __('comment.validations.invalid captcha'),

            'title.max' => __('comment.validations.max' , ['field' => __('comment.title') , 'max' => 70]),
            'commentable_id.integer' => __('comment.validations.integer' , ['field' => __('comment.commentable_id')]),
        ]);

        if ($validator->fails())
        {
            return self::FailResponse($validator->messages()->first());
        }

        return false;
    }
}
