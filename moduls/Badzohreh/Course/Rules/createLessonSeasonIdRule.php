<?php

namespace Badzohreh\Course\Rules;

use Badzohreh\Course\Repositories\SeassonRepo;
use Illuminate\Contracts\Validation\Rule;

class createLessonSeasonIdRule implements Rule
{

    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        $season = resolve(SeassonRepo::class)
            ->findByCourseAndSeason($value, request()->route("course"));
        if ($season) return true;
        return false;
    }


    public function message()
    {
        return 'سرفصل مورد نظر معتبر نیست.';
    }
}
