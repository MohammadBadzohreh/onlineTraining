<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\LessonRequest;
use Badzohreh\Course\Models\Lesson;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Course\Repositories\LessonRepo;
use Badzohreh\Course\Repositories\SeassonRepo;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\RolePermissions\Models\Permission;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public $lessonRepo;
    public $courseRepo;

    public function __construct(LessonRepo $lessonRepo, CourseRepo $courseRepo)
    {

        $this->lessonRepo = $lessonRepo;
        $this->courseRepo = $courseRepo;
    }

    public function create($id, SeassonRepo $seassonRepo)
    {
        $course = $this->courseRepo->findById($id);
        $this->authorize("createLesson", $course);
        $seassons = $seassonRepo->getCourseSeassons($course->id);
        return view("Course::lessons.create", compact("course", "seassons"));
    }

    public function store($id, LessonRequest $request)
    {
        $course = $this->courseRepo->findById($id);
        $this->authorize("createLesson", $course);
        $request->request->add(["media_id" =>
            MediaService::privateUpload($request->file("lesson-upload"))->id]);
        $this->lessonRepo->create($id, $request);
        return redirect()->route("seassons.index", $id);
    }


    public function accpet($id)
    {
        $lesson = $this->lessonRepo->findById($id);
        $this->authorize("changeConfirmation_status",$lesson);
        if ($this->lessonRepo->
        updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::successResponses();
        } else {
            return AjaxResponses::failResponses();
        }
    }

    public function reject($id)
    {
        $lesson = $this->lessonRepo->findById($id);
        $this->authorize("changeConfirmation_status",$lesson);
        if ($this->lessonRepo->
        updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::successResponses();
        } else {
            return AjaxResponses::failResponses();
        }
    }

    public function lock($id)
    {
        $lesson = $this->lessonRepo->findById($id);
        $this->authorize("change_status",$lesson);
        if ($this->lessonRepo->
        updateStatus($id, Lesson::STATUS_CLOSED)) {
            return AjaxResponses::successResponses();
        } else {
            return AjaxResponses::failResponses();
        }
    }


    public function unlock($id)
    {
        $lesson = $this->lessonRepo->findById($id);
        $this->authorize("change_status",$lesson);
        if ($this->lessonRepo->
        updateStatus($id, Lesson::STATUS_OPENED)) {
            return AjaxResponses::successResponses();
        } else {
            return AjaxResponses::failResponses();
        }
    }


    public function destroy($course_id, $lesson_id)
    {
        $lesson = $this->lessonRepo->findById($lesson_id);
        $this->authorize("delete",$lesson);
        if ($lesson->banner) {
            $lesson->banner->delete();
        }
        $lesson->delete();
        showFeedbacks();
        return AjaxResponses::successResponses();
    }

    public function deleteMultiple(Request $request)
    {
        $ids = explode(",", $request->ids);
        foreach ($ids as $id) {
            $lesson = $this->lessonRepo->findById($id);
            $this->authorize("delete",$lesson);
            if ($lesson->banner) {
                $lesson->banner->delete();
            }
            $lesson->delete();
        }
        return redirect()->back();
    }

    public function edit($courseId, $lessonId, SeassonRepo $seassonRepo)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize("edit",$lesson);
        $course = $this->courseRepo->findById($courseId);
        $seassons = $seassonRepo->getCourseSeassons($courseId);
        return view("Course::lessons.edit", compact('lesson', 'seassons', "course"));
    }

    public function update($courseId, $lessonId, LessonRequest $request)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize("edit",$lesson);
        if ($request->file("lesson-upload")) {
            if ($lesson->media) {
                $lesson->media->delete();
            }
            $request->request->add(["media_id" =>
                MediaService::privateUpload($request->file("lesson-upload"))->id]);
        } else {
            $request->media_id = $lesson->media_id;
        }
        $this->lessonRepo->update($courseId, $lessonId, $request);
        showFeedbacks();
        return redirect()->route("seassons.index", $courseId);
    }

    public function accpetAll($courseId)
    {
        $course = $this->courseRepo->findById($courseId);
        $this->authorize("accpetLessons",$course);
        $this->courseRepo->acceptAll($courseId);
        showFeedbacks();
        return back();
    }

    public function acceptSelected($courseId, Request $request)
    {
        $course = $this->courseRepo->findById($courseId);
        $this->authorize("accpetLessons",$course);
        $ids = explode(',', $request->ids);
        $this->lessonRepo->acceptSelected($courseId, $ids);
        return back();
    }

    public function rejectSelected($courseId, Request $request)
    {
        $course = $this->courseRepo->findById($courseId);
        $this->authorize("change_confirmation_status",$course);
        $ids = explode(',', $request->ids);
        $this->lessonRepo->rejectselected(
            $courseId, $ids);
        return back();
    }

}