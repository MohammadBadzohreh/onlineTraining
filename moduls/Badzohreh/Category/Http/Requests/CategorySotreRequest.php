<?php

namespace Badzohreh\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorySotreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ==true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"=>"required|string|max:190",
            'slug'=>'required|string',
            'parent_id'=>'nullable|exists:categories,id'
        ];
    }
}
