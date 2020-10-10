<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Course\Http\Requests\LessonRequest;
use Badzohreh\Course\Models\Season;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Course\Repositories\LessonRepo;
use Badzohreh\Course\Repositories\SeassonRepo;
use Badzohreh\Media\Services\MediaService;

class LessonController extends Controller
{


    public function __construct()
    {

    }

    public function create($id,CourseRepo $courseRepo,SeassonRepo $seassonRepo){
        $course = $courseRepo->findById($id);
        $seassons = $seassonRepo->getCourseSeassons($course->id);
        return view("Course::lessons.create", compact("course", "seassons"));
    }
    public function store($id,LessonRequest $request,LessonRepo $lessonRepo){

        $request->request->add(["media_id"=>
            MediaService::uplaod($request->file("lesson-upload"))->id]);
        $lessonRepo->create($id,$request);
    }


}