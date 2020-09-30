<?php

namespace Badzohreh\User\Http\Requests;

use Badzohreh\User\Models\User;
use Badzohreh\User\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name"=>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->route("user"),
            'mobile' => ['nullable', 'string', 'min:9' , 'max:14', 'unique:users,mobile,'.$this->route("user"), new ValidMobile()],
            'password' => "nullable|string",
            "image"=>"nullable|mimes:jpeg,jpg,png",
            "status"=>["required",Rule::in(User::$STATUSES)],
            "headline"=>"nullable|string|min:5|max:100",
        ];
    }

}
