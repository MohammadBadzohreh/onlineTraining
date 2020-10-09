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
    private $courseRepo;

    public function __construct(SeassonRepo $seassonRepo, CourseRepo $courseRepo)
    {

        $this->seassonRepo = $seassonRepo;
        $this->courseRepo = $courseRepo;
    }

    public function index($id)
    {
        $this->authorize("detail", $this->courseRepo->findById($id));
        $course = $this->courseRepo->findById($id);
        return view("Course::seasons.detail", compact("course"));
    }

    public function store($id, SeasonStoreRequest $request)
    {
        $this->authorize("createSeason", $this->courseRepo->findById($id));

        $this->seassonRepo->create($id, $request);
        return back();
    }

    public function edit($id)
    {
        $season = $this->seassonRepo->findById($id);
        $this->authorize("edit", $season);
        return view("Course::seasons.edit", compact("season"));
    }


    public function update($id, SeasonStoreRequest $request)
    {
        $this->authorize("edit", $this->seassonRepo->findById($id));
        $this->seassonRepo->update($id, $request);
        return back();
    }

    public function accept($id)
    {
        $this->authorize("changeConfirmation_status", $this->seassonRepo->findById($id));
        if ($this->seassonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_ACCEPTED)) {
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }

    public function reject($id)
    {
        $this->authorize("changeConfirmation_status", $this->seassonRepo->findById($id));

        if ($this->seassonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_REJECTED)) {
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


    public function open($id)
    {
        $this->authorize("changeConfirmation_status", $this->seassonRepo->findById($id));

        if ($this->seassonRepo->updateStatus($id, Season::STATUS_OPENED)) {
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


    public function close($id)
    {
        $this->authorize("changeConfirmation_status", $this->seassonRepo->findById($id));

        if ($this->seassonRepo->updateStatus($id, Season::STATUS_CLOSED)) {
            showFeedbacks();
            AjaxResponses::successResponses();
        }
        AjaxResponses::failResponses();
    }


}
