<?php

namespace Badzohreh\Category\Repositories;

use Badzohreh\Category\Models\Category;

class CategoryRepo
{
    public function all()
    {
        return Category::all();
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function allExpectId($id)
    {

        return $this->all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });

    }

    public function store($values)
    {
        Category::create([
            "title" => $values->title,
            "slug" => $values->slug,
            "parent_id" => $values->parent_id
        ]);
    }


    public function update($id, $values)
    {
        Category::where("id", $id)->update([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function delete($id)
    {
        Category::where("id", $id)->delete();
    }

    public function tree()
    {
        return Category::query()->where("parent_id", null)
            ->with("category_children")
            ->get();
    }
}