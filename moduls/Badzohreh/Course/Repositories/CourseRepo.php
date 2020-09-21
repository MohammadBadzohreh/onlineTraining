<?php

namespace Badzohreh\Course\Repositories;

use Badzohreh\Course\Models\Course;

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
        ]);
        return $course;
    }

    public function findById($id)
    {
        return Course::findOrFail($id);
    }

    public function update($id,$values)
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
}