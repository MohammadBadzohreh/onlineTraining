<?php

namespace Badzohreh\Course\Repositories;

use Badzohreh\Course\Models\Course;

class CourseRepo
{
    public function store($values)
    {

//        add banner_id

        Course::create([
            "teacher_id"=>$values->teacher_id,
            "category_id"=>$values->category_id,
            "title"=>$values->title,
            "slug"=>$values->slug,
            "price"=>$values->price,
            "percent"=>$values->percent,
            "type"=>$values->type,
            "status"=>$values->status,
            "body"=>$values->body,
            "banner_id"=>$values->banner_id
        ]);
    }
}