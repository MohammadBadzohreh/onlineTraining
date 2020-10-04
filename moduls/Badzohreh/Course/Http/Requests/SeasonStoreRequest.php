<?php

namespace Badzohreh\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeasonStoreRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            "title"=>"required|string|min:3|max:100",
            "number"=>"nullable|int|min:0|max:250",
        ];
    }
}
