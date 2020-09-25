<?php

namespace Badzohreh\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Http\Requests\CategorySotreRequest;
use Badzohreh\Category\Models\Category;
use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Category\Responses\AjaxResponses;

class CategoryController extends Controller
{

    private $repo;
    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->repo = $categoryRepo;
    }

    public function index()
    {
        $this->authorize("manage",Category::class);

        /*todo: delete user varible*/
        $user=auth()->user();
        $categories = $this->repo->all();
        return view("Categories::index", compact('categories'));
    }

    public function store(CategorySotreRequest $request)
    {

        $this->authorize("manage",Category::class);

        $this->repo->store($request);
        return back();
    }


    public function edit($categoryId)
    {
        $this->authorize("manage",Category::class);

        $category=$this->repo->findById($categoryId);
        $categories = $this->repo->allExpectId($categoryId);
        return view("Categories::edit", compact('category', 'categories'));
    }

    public function update($categoryId, CategorySotreRequest $request)
    {
        $this->authorize("manage",Category::class);
        $this->repo->update($categoryId,$request);
        return back();
    }

    public function destroy($categoryId)
    {
        $this->authorize("manage",Category::class);

        $this->repo->delete($categoryId);
        return AjaxResponses::successResponses();
    }
}