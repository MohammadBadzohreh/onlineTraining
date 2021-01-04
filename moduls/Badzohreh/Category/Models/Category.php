<?php

namespace Badzohreh\Category\Models;

use Badzohreh\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class Category extends Model
{
    protected $fillable = ["title", "slug", "parent_id"];


//    getter


    public function getParentAttribute()
    {
        return (!is_null($this->parent_id))
            ?
            $this->category_parent->title
            :
            'ندارد';
    }

//relations

    public function category_children()
    {
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    public function category_parent()
    {
        return $this->belongsTo(Category::class, "parent_id", "id");
    }

    public function course()
    {
        return $this->belongsTo(Course::class, "category_id", "id");
    }


    public function path()
    {
//        todo fix category path
        return "asss";
    }


}
