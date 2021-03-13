<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\CourseStoreRequest;
use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Services\PaymentServices;
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

    public function buy($courseId, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($courseId);
        if (!$this->canPuchasedCourse($course)) {
            return back();
        }
        if (!$this->authUserCanPurchaseCourse($course)) {
            return back();
        }
        $amount = $course->getFinalPrice();
        if ($amount <= 0) {
            $courseRepo->addStudentToCourse($course, auth()->id());
            showFeedbacks("موفقیت آمیز", "شما با موفقیت در دور ثبت نام کردید.");
            return redirect()->to($course->path());
        }
        $payment = PaymentServices::generate($amount, $course, auth()->user(),$course->teacher_id);
        resolve(Gateway::class)->redirect();
    }

    private function canPuchasedCourse(Course $course)
    {
        if ($course->type == Course::TYPE_FREE) {
            showFeedbacks("خطا در عملیات", "دوره های رایگان قابل خریداری نیستند");
            return false;
        }
        if ($course->confirmation_status != Course::ACCEPTED_CONFIRMATION_STATUS) {
            showFeedbacks("خطا در عملیات", "دوره توسط مدیر تایید نشده است.");
            return false;
        }
        if ($course->status == Course::STATUS_LOCKED) {
            showFeedbacks("خطا در عملیات", "دوره های قفل شده قابل خریدداری نیستند");
            return false;
        }
        return true;
    }

    private function authUserCanPurchaseCourse(Course $course)
    {
        if (auth()->user() && auth()->user()->hasAceesToCourse($course)) {
            showFeedbacks("خطا در عملیات", "شما به این دوره دسترسی دارید.");
            return false;
        }
        return true;
    }


    public function downloadLinks($course_id)
    {
        $course = $this->CourseRepo->findById($course_id);
        $this->authorize("download" , $course);
        $links = $course->downloadLinks();
        return implode("<br>" , $links);
    }
}
