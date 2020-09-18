<?php

namespace Badzohreh\Course\Http\Requests;

use Badzohreh\Course\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "title"=>"required|string|min:3|max:190",
            "slug"=>"required|min:3|max:150|unique:courses,slug",
            "priority"=>"nullable|numeric",
            "price"=>"required|numeric|min:0|max:10000000",
            "percent"=>"required|numeric|min:0|max:100",
            "teacher_id"=>["required","exists:users,id"],
            "type"=>["required",Rule::in(Course::$TYPES)],
            "status"=>["required",Rule::in(Course::$STATUSES)],
            "category_id"=>"nullable|exists:categoris,id",
            "image"=>"required|mimes:jpeg,png"
        ];

    }

    public function attributes()
    {
        return[
            "slug"=>"نام انگلیسی دوره",
            "priority"=>"ردیف دوره",
            "price"=>"قیمت",
            "percent"=>"درصد",
            "teacher_id"=>"نام مدرس",
            "type"=>"نوع دوره",
            "status"=>"وضعیت",
        ];
    }

}
