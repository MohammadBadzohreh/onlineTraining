<?php

namespace Badzohreh\Course\Repositories;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Models\Lesson;
use phpDocumentor\Reflection\Types\Integer;

class CourseRepo
{
    public function all()
    {
        return Course::all();
    }


    public function store($values)
    {
        $course = Course::create([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
            "banner_id" => $values->banner_id,
            "title" => $values->title,
            "slug" => $values->slug,
            "price" => $values->price,
            "percent" => $values->percent,
            "type" => $values->type,
            "status" => $values->status,
            "body" => $values->body,
            "confirmation_status" => Course::PENDING_CONFIRMATION_STATUS,
        ]);
        return $course;
    }

    public function findById($id)
    {
        return Course::findOrFail($id);
    }

    public function update($id, $values)
    {
        $this->findById($id)->update([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
            "banner_id" => $values->banner_id,
            "title" => $values->title,
            "slug" => $values->slug,
            "price" => $values->price,
            "percent" => $values->percent,
            "type" => $values->type,
            "status" => $values->status,
            "body" => $values->body,
        ]);
    }


    public function destory($id)
    {

        $course = $this->findById($id);
        if ($course->banner) {
            $course->banner->delete();
        }
        $course->delete();
    }


    public function acceptAll($courseId)
    {
        $course = $this->findById($courseId);
        $course->lessons()->update([
            "confirmation_staus" => Lesson::CONFIRMATION_STATUS_ACCEPTED
        ]);


    }


    public function change_confirmation_status($id, $status)
    {
        $course = $this->findById($id);
        if ($course->update(["confirmation_status" => $status])) {
            return true;
        }
        return false;
    }

    public function change_status($id, $status)
    {
        $course = $this->findById($id);
        if ($course->update(["status" => $status])) {
            return true;
        }
        return false;
    }

    public function latest_course()
    {
        return Course::query()
            ->where("confirmation_status",
                Course::ACCEPTED_CONFIRMATION_STATUS)
            ->latest()->take(8)->get();
    }

    public function lessonCount($course_id)
    {
        return Lesson::query()->where([
            "course_id" => $course_id,
            "confirmation_staus" => Lesson::CONFIRMATION_STATUS_ACCEPTED,
        ])->count();
    }

    public function addStudentToCourse(Course $course, $studentId)
    {
        if (!$this->studentCourse($course, $studentId)) {
            $course->students()->attach($studentId);
        }
    }

    public function studentCourse(Course $course, $studentId)
    {
        return $course->students()->where("id", $studentId)->first();

    }

    public function hasStudent(Course $course,$student_id)
    {
        return $course->students->contains($student_id);
    }


}
