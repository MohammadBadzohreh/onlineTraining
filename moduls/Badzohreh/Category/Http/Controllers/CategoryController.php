<?php

namespace Badzohreh\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Http\Requests\CategorySotreRequest;
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
        $categories = $this->repo->all();
        return view("Categories::index", compact('categories'));
    }

    public function store(CategorySotreRequest $request)
    {
        $this->repo->store($request);
        return back();
    }


    public function edit($categoryId)
    {
        $category=$this->repo->findById($categoryId);
        $categories = $this->repo->allExpectId($categoryId);
        return view("Categories::edit", compact('category', 'categories'));
    }

    public function update($categoryId, CategorySotreRequest $request)
    {
        $this->repo->update($categoryId,$request);
        return back();
    }

    public function destroy($categoryId)
    {
        $this->repo->delete($categoryId);
        return AjaxResponses::successResponses();
    }
}