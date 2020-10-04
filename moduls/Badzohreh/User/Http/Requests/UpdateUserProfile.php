<?php

namespace Badzohreh\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfile extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }


    public function rules()
    {
        return [
            'image' => 'required',
        ];
    }
}
