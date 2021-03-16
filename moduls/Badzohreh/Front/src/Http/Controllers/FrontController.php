<?php

namespace Badzohreh\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Course\Repositories\LessonRepo;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        return view("Front::index");
    }

    public function singleCourse($slug, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {

        $course_id = $this->extractId($slug, "-c");
        $course = $courseRepo->findById($course_id);
        $lessons = $lessonRepo->getCourseLessons($course_id);

        if (request()->has("lesson")) {
            $lessonId = $this->extractId(request()->get("lesson"), "l-");
            $lesson = $lessonRepo->getLessonCourseById($course_id, $lessonId);

        } else {
            $lesson = $lessonRepo->getFirstLessonCourse($course_id);
        }

        return view("Front::single-course", compact("course", "lessons", "lesson"));
    }

    public function tutor($username)
    {
        $tutor = User::permission(Permission::PERMISSION_TEACH)->where("name", $username)->first();

        return view("Front::tutor",compact("tutor"));

    }


    public function extractId($string, $search)
    {
        return Str::before(Str::after($string, $search), "-");
    }
}
