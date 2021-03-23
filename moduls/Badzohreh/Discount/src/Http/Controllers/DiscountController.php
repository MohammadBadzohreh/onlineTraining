<?php

namespace Badzohreh\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Discount\Http\Requests\StoreDiscountRequest;
use Badzohreh\Discount\Http\Requests\UpdateDiscountRequest;
use Badzohreh\Discount\Repositories\DiscountRepo;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use function React\Promise\reduce;

class DiscountController extends Controller
{

    private $discountRepo;

    public function __construct(DiscountRepo $discountRepo)
    {

        $this->discountRepo = $discountRepo;
    }

    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->allCourseBylatest();
        $discounts = $this->discountRepo->paginate();

        return view("Discount::index", compact("courses", "discounts"));
    }

//todo store discount request
    public function store(StoreDiscountRequest $request)
    {
        $this->discountRepo->store($request->all());
        showFeedbacks();
        return back();
    }

    public function edit($discount_id, CourseRepo $courseRepo)
    {
        $courses = $courseRepo->allCourseBylatest();
        $discount = $this->discountRepo->findOrFail($discount_id);
        return view("Discount::edit", compact("discount", "courses"));
    }

    public function update(UpdateDiscountRequest $request,$discount_id)
    {
        $this->discountRepo->update($request->all(),$discount_id);
        showFeedbacks();
        return redirect()->route("discount.index");
    }

    public function delete()
    {

    }
}
