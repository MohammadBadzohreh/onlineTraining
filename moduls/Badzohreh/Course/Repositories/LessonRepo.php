<?php

namespace Badzohreh\Course\Repositories;


use Badzohreh\Course\Models\Lesson;
use Badzohreh\Course\Models\Season;
use Doctrine\DBAL\Schema\View;
use Illuminate\Support\Str;

class LessonRepo
{
    public function findById($id)
    {
        return Lesson::find($id);
    }

    public function create($id, $values)
    {
        Lesson::create([
            "title" => $values->title,
            "slug" => $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            "number" => $this->generate_number($id),
            "time" => $values->time,
            "is_free" => $values->is_free,
            "season_id" => $values->season_id,
            "media_id" => $values->media_id,
            "user_id" => auth()->id(),
            "course_id" => $id,
            "body" => $values->body,
        ]);

    }

    public function update($courseId, $lessonId, $values)
    {
        $lesson = $this->findById($lessonId);
        $lesson->update([
            "title" => $values->title,
            "slug" => $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            "number" => $this->generate_number($courseId),
            "time" => $values->time,
            "is_free" => $values->is_free,
            "season_id" => $values->season_id,
            "media_id" => $values->media_id,
            "user_id" => auth()->id(),
            "course_id" => $courseId,
            "body" => $values->body,
        ]);
    }



    public function updateConfirmationStatus($id, $status)
    {
        $season = $this->findById($id);
        if ($season->update(["confirmation_staus" => $status])) {
            return true;
        }
        return false;
    }

    public function updateStatus($id, $status)
    {
        $lesson = $this->findById($id);
        if ($lesson->update(["status" => $status])) {
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


    private function generate_number($id, $number = null)
    {
        $courseRepo = new CourseRepo();
        if (is_null($number)) {
            $number = $courseRepo->findById($id)->lessons()->orderBy("number", "desc")->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }

    public function acceptSelected($courseId, array $ids)
    {
        return Lesson::query()->where("course_id",$courseId)->whereIn('id',$ids)
            ->update(["confirmation_staus"=>Lesson::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function rejectselected($courseId, array $ids)
    {
        return Lesson::query()->where("course_id",$courseId)->whereIn('id',$ids)
            ->update(["confirmation_staus"=>Lesson::CONFIRMATION_STATUS_REJECTED]);
    }


}