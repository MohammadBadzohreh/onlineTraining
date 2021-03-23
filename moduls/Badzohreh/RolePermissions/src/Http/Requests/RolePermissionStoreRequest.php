<?php

namespace Badzohreh\RolePermissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'permissions' => 'nullable|array|min:1',
        ];
    }

    public function attributes()
    {
        return [
            "permissions" => "نقش کاربری"
        ];
    }
}
