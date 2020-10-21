<?php

namespace Badzohreh\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
//        add rules to this
        return [

        ];
    }
}
