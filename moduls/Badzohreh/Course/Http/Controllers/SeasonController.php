<?php

namespace Badzohreh\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Http\Requests\SeasonStoreRequest;
use Badzohreh\Course\Models\Season;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Course\Repositories\SeassonRepo;

class SeasonController extends Controller
{


    private $seassonRepo;

    public function __construct(SeassonRepo $seassonRepo)
    {

        $this->seassonRepo = $seassonRepo;
    }

    public function index($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        return view("Course::seasons.detail", compact("course"));
    }

    public function store($id, SeasonStoreRequest $request)
    {
        $this->seassonRepo->create($id,$request);
        return back();
    }

    public function edit($id)
    {
        $season =$this->seassonRepo->findById($id);
        return view("Course::seasons.edit",compact("season"));
    }


    public function update($id,SeasonStoreRequest $request)
    {
        $this->seassonRepo->update($id,$request);
        return back();
    }

    public function accept($id)
    {
        if ($this->seassonRepo->updateConfirmationStatus($id,Season::CONFIRMATION_STATUS_ACCEPTED)){
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }
    public function reject($id)
    {
        if ($this->seassonRepo->updateConfirmationStatus($id,Season::CONFIRMATION_STATUS_REJECTED)){
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


    public function open($id)
    {
        if ($this->seassonRepo->updateStatus($id,Season::STATUS_OPENED)){
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


    public function close($id)
    {
        if ($this->seassonRepo->updateStatus($id,Season::STATUS_CLOSED)){
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


}
