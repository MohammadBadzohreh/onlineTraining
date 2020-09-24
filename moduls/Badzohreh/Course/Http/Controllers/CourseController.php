<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Category\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\CourseStoreRequest;
use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\User\Repositories\UserRepo;

class CourseController extends Controller
{

    public $CourseRepo;
    public $UserRepo;
    public $CategoryRepo;

    public function __construct(CourseRepo $CourseRepo, UserRepo $UserRepo, CategoryRepo $CategoryRepo)
    {
        $this->CourseRepo = $CourseRepo;
        $this->UserRepo = $UserRepo;
        $this->CategoryRepo = $CategoryRepo;
    }


    public function index()
    {
        $this->authorize('manage',Course::class);
        $courses = $this->CourseRepo->all();
        return view("Course::index", compact("courses"));
    }


    public function create()
    {
        $teachers = $this->UserRepo->getTeacher();
        $categories = $this->CategoryRepo->all();
        return view("Course::create", compact("teachers", "categories"));
    }



    public function store(CourseStoreRequest $request)
    {
        $request->request
            ->add(['banner_id' => MediaService::uplaod($request->file("image"))->id]);
        $this->CourseRepo->store($request);
        return redirect()->route("course.index");
    }

    public function edit($id)
    {
        $teachers = $this->UserRepo->getTeacher();
        $course = $this->CourseRepo->findById($id);
        $categories = $this->CategoryRepo->all();
        return view("Course::edit", compact("course", 'teachers', "categories"));
    }


    public function update($id, CourseStoreRequest $request)
    {
        if ($request->file("image")) {

            $this->CourseRepo->findById($id)->banner->delete();
            $request->banner_id = MediaService::uplaod($request->file("image"))->id;
        } else {
            $request->banner_id = $this->CourseRepo->findById($id)->banner_id;
        }
        $this->CourseRepo->update($id, $request);
        return redirect()->route("course.index");
    }

    public function destroy($id)
    {
        $this->CourseRepo->destory($id);
        return AjaxResponses::successResponses();
    }


    public function accpet($id)
    {
        if ($this->CourseRepo->change_confirmation_status($id,Course::ACCEPTED_CONFIRMATION_STATUS)){
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }
    public function reject($id)
    {
        if ($this->CourseRepo->change_confirmation_status($id,Course::REJECTED_CONFIRMATION_STATUS)){
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

    public function lock($id)
    {
        if ($this->CourseRepo->change_status($id,Course::STATUS_LOCKED)){
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

}