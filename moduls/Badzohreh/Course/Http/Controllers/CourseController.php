<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\CourseStoreRequest;
use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\RolePermissions\Models\Permission;
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
        $this->authorize('manage', Course::class);
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) &&
            !auth()->user()->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN)) {
            $courses = auth()->user()->courses;
        } else {
            $courses = $this->CourseRepo->all();
        }
        return view("Course::index", compact("courses"));
    }


    public function create()
    {
        $this->authorize("create", Course::class);
        $teachers = $this->UserRepo->getTeacher();
        $categories = $this->CategoryRepo->all();
        return view("Course::create", compact("teachers", "categories"));
    }


    public function store(CourseStoreRequest $request)
    {
        $this->authorize("create", Course::class);
        $request->request
            ->add(['banner_id' => MediaService::publicUplaod($request->file("image"))->id]);
        $this->CourseRepo->store($request);
        return redirect()->route("course.index");
    }

    public function edit($id)
    {
        $course = $this->CourseRepo->findById($id);
        $this->authorize("edit", $course);
        $teachers = $this->UserRepo->getTeacher();
        $course = $this->CourseRepo->findById($id);
        $categories = $this->CategoryRepo->all();
        return view("Course::edit", compact("course", 'teachers', "categories"));
    }


    public function update($id, CourseStoreRequest $request)
    {
        $course = $this->CourseRepo->findById($id);
        $this->authorize("edit", $course);
        if ($request->file("image")) {
            if ($course->banner) {
                $course->banner->delete();
            }
            $request->request
                ->add(["banner_id" => MediaService::publicUplaod($request->file("image"))->id]);

        } else {
            $request->banner_id = $course->banner_id;
        }
        $this->CourseRepo->update($id, $request);
        return redirect()->route("course.index");
    }

    public function destroy($id)
    {
        $this->authorize("delete", Course::class);
        $this->CourseRepo->destory($id);
        return AjaxResponses::successResponses();
    }


    public function accpet($id)
    {
        $this->authorize("change_status_confirmation", Course::class);
        if ($this->CourseRepo->change_confirmation_status($id, Course::ACCEPTED_CONFIRMATION_STATUS)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

    public function reject($id)
    {
        $this->authorize("change_status_confirmation", Course::class);

        if ($this->CourseRepo->change_confirmation_status($id, Course::REJECTED_CONFIRMATION_STATUS)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

    public function lock($id)
    {
        $this->authorize("change_status_confirmation", Course::class);

        if ($this->CourseRepo->change_status($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

}