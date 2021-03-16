<?php

namespace Badzohreh\Course\Repositories;


use Badzohreh\Course\Models\Season;
use Doctrine\DBAL\Schema\View;

class SeassonRepo
{
    public function findById($id)
    {
        return Season::find($id);
    }

    public function create($id, $values)
    {
        Season::create([
            "title" => $values->title,
            "number" => $this->generate_number($values->number, $id),
            "user_id" => auth()->id(),
            "course_id" => $id,
        ]);

    }

    public function update($id, $values)
    {

        $season = $this->findById($id);
        $season->update([
            "title" => $values->title,
            "number" => $this->generate_number($values->number, $id),
        ]);
    }

    public function updateConfirmationStatus($id, $status)
    {
        $season = $this->findById($id);
        if ($season->update(["confirmation_status" => $status])) {
            return true;
        }
        return false;
    }

    public function updateStatus($id, $status)
    {
        $season = $this->findById($id);
        if ($season->update(["status" => $status])) {
            return true;
        }
        return false;
    }

    public function getCourseSeassons($course_id)
    {
        return Season::query()
            ->where([
                "course_id" => $course_id,
                "confirmation_status" => Season::CONFIRMATION_STATUS_ACCEPTED
            ])
            ->orderBy("number")->get();
    }


    public function findByCourseAndSeason($season_id, $course_id)
    {
        return Season::query()->where([
            "id" => $season_id,
            "course_id" => $course_id
        ])->get();

    }

    private function generate_number($number, $id)
    {
        $courseRepo = new CourseRepo();
        if (is_null($number)) {
            $number = $courseRepo->findById($id)->seassons()->orderBy("number", "desc")->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }


}