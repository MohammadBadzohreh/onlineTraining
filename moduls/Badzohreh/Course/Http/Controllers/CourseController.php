<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Course\Http\Requests\CourseStoreRequest;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\User\Repositories\UserRepo;

class CourseController extends Controller
{

    public function create(UserRepo $UserRepo,CategoryRepo $CategoryRepo)
    {
        $teachers = $UserRepo->getTeacher();
        $categories = $CategoryRepo->all();

        return view("Course::create",compact("teachers","categories"));
    }

    public function store(CourseStoreRequest $request,CourseRepo $CourseRepo)
    {

        $request->request
            ->add(['banner_id'=>MediaService::uplaod($request->file("image"))->id]);


        $course = $CourseRepo->store($request);
        return $course;
    }

}