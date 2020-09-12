<?php

namespace Badzohreh\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Http\Requests\CategorySotreRequest;
use Badzohreh\Category\Models\Category;
use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        //todo move categoryRepository

        $categories = Category::all();

        return view("Categories::index", compact('categories'));
    }

    public function store(CategorySotreRequest $request)
    {
        Category::create([
            "title" => $request->title,
            "slug" => $request->slug,
            "parent_id" => $request->parent_id
        ]);
        return back();
    }


    public function edit(Category $category)
    {
        $categories = Category::query()->where("id","!=",$category->id)->get();
        return view("Categories::edit", compact('category', 'categories'));
    }

    public function update(Category $category, CategorySotreRequest $request)
    {
        $category->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
        ]);
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message'=>'عملیات با موفقیت انجام شد.'],
            Response::HTTP_OK);
    }
}