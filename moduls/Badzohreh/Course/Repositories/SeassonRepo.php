<?php

namespace Badzohreh\Course\Repositories;


use Badzohreh\Course\Models\Season;

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
            "number" => $this->generate_number($values->number,$id),
            "user_id" => auth()->id(),
            "course_id" => $id,
        ]);

    }

    public function update($id, $values)
    {

        $season = $this->findById($id);
        $season->update([
            "title"=>$values->title,
            "number"=>$this->generate_number($values->number,$id),
        ]);
    }
     private function generate_number($number,$id)
     {
         $courseRepo = new CourseRepo();
         if (is_null($number)) {
             $number = $courseRepo->findById($id)->seassons()->orderBy("number", "desc")->firstOrNew([])->number ?: 0;
             $number++;
         }
         return $number;
     }
}