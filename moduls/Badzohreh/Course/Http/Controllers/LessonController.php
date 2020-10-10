<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\LessonRequest;
use Badzohreh\Course\Models\Season;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Course\Repositories\LessonRepo;
use Badzohreh\Course\Repositories\SeassonRepo;
use Badzohreh\Media\Services\MediaService;

class LessonController extends Controller
{

    public $lessonRepo;
    public $courseRepo;

    public function __construct(LessonRepo $lessonRepo,CourseRepo $courseRepo)
    {

        $this->lessonRepo = $lessonRepo;
        $this->courseRepo = $courseRepo;
    }

    public function create($id,SeassonRepo $seassonRepo){
        $course = $this->courseRepo->findById($id);
        $seassons = $seassonRepo->getCourseSeassons($course->id);
        return view("Course::lessons.create", compact("course", "seassons"));
    }
    public function store($id,LessonRequest $request){

        $request->request->add(["media_id"=>
            MediaService::privateUpload($request->file("lesson-upload"))->id]);
        $this->lessonRepo->create($id,$request);
        return redirect()->route("seassons.index",$id);
    }

    public function destroy($course_id,$lesson_id){
        $lesson = $this->lessonRepo->findById($lesson_id);
        if ($lesson->banner){
            $lesson->banner->delete();
        }
        $lesson->delete();
        showFeedbacks();
        return AjaxResponses::successResponses();
    }


}