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
        $rules = [
            "title" => "required|string|min:3|max:190",
            "slug" => "required|min:3|max:150|unique:courses,slug",
            "priority" => "nullable|numeric",
            "price" => "required|numeric|min:0|max:10000000",
            "percent" => "required|numeric|min:0|max:100",
            "teacher_id" => ["required", "exists:users,id"], //todo  validate teacher
            "type" => ["required", Rule::in(Course::$TYPES)],
            "status" => ["required", Rule::in(Course::$STATUSES)],
            "category_id" => "required|exists:categories,id",
            "image" => "required|mimes:jpeg,png"
        ];

        if ($this->method("PATCH")) {
            $rules["slug"] = "required|min:3|max:150|unique:courses,slug," . request()->route("course");

            $rules["image"] = "nullable|mimes:jpeg,png";
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            "slug" => "نام انگلیسی دوره",
            "priority" => "ردیف دوره",
            "price" => "قیمت",
            "percent" => "درصد",
            "teacher_id" => "نام مدرس",
            "type" => "نوع دوره",
            "status" => "وضعیت",
        ];
    }

}
