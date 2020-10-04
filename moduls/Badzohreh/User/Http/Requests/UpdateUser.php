<?php

namespace Badzohreh\User\Http\Requests;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }


    public function rules()
    {
        $rules = [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email," . auth()->id(),
            "mobile" => ['nullable', 'string', 'min:9', 'max:14', 'unique:users,mobile,' . auth()->id()],
            'password' => ['nullable', 'string', new ValidPassword()],
            "username" => 'nullable|min:3|max:190|unique:users,username,' . auth()->id(),
            "card_number" => "nullable|string|size:16",
            "shaba" => "nullable|string|size:24",
        ];
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            $rules['headline'] = 'required|string|min:3|max:100';
            $rules["username"] = 'required|min:3|max:190|unique:users,username,' . auth()->id();
            $rules ["card_number"] = "required|string|size:16";
            $rules["shaba"] = "required|string|size:24";
            $rules["bio"] = "required|string";
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            "shaba"=>"شماره شبا",
            "bio"=>"بیو",
            "card_number"=>"شماره کارت",
            "headline"=>"عنوان",
        ];
    }
}
