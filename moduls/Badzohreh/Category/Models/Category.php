<?php

namespace Badzohreh\Category\Models;

use Illuminate\Database\Eloquent\Model;

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


}
