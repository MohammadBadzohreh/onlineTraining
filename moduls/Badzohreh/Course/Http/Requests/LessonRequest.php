<?php

namespace Badzohreh\Course\Http\Requests;

use Badzohreh\Course\Rules\createLessonSeasonIdRule;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {

        $rules =  [
            "title" => "required|string|min:3",
            "slug" => "nullable|string|min:3|max:200",
            "number" => "nullable|numeric|min:0|max:500",
            "time" => "nullable|numeric|min:0",
            "free" => "nullable|boolean",
            "season_id" => ["nullable",new createLessonSeasonIdRule()],
            "lesson-upload" => "required|mimes:avi,mkv,mp4,zip",
        ];

        if (request()->method() =="PATCH"){
            $rules['lesson-upload'] = "nullable|mimes:avi,mkv,mp4,zip";
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            "title" => "عنوان",
            "slug" => "نام انگلیسی",
            "number" => "شماره",
            "time" => "زمان",
            "free" => "رایگان",
            "season_id" => "سرفصل",
            "lesson-upload" => "جلسه",
        ];
    }
}
