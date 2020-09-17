<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Course\Http\Requests\CourseStoreRequest;
use Badzohreh\Course\Repositories\CourseRepo;

class CourseController extends Controller
{

    public function create(CourseRepo $CourserRepo,CategoryRepo $CategoryRepo)
    {
        $teachers = $CourserRepo->getTeacher();
        $categories = $CategoryRepo->all();

        return view("Course::create",compact("teachers","categories"));
    }

    public function store(CourseStoreRequest $request)
    {

    }

}