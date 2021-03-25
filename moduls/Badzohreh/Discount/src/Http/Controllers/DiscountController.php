<?php

namespace Badzohreh\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Discount\Http\Requests\StoreDiscountRequest;
use Badzohreh\Discount\Http\Requests\UpdateDiscountRequest;
use Badzohreh\Discount\Models\Discount;
use Badzohreh\Discount\Repositories\DiscountRepo;
use Badzohreh\Discount\Services\DiscountServices;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    private $discountRepo;

    public function __construct(DiscountRepo $discountRepo)
    {

        $this->discountRepo = $discountRepo;
    }

    public function index(CourseRepo $courseRepo)
    {
        $this->authorize("manage", Discount::class);
        $courses = $courseRepo->allCourseBylatest();
        $discounts = $this->discountRepo->paginate();

        return view("Discount::index", compact("courses", "discounts"));
    }

    public function store(StoreDiscountRequest $request)
    {
        $this->authorize("manage", Discount::class);
        $this->discountRepo->store($request->all());
        showFeedbacks();
        return back();
    }

    public function edit($discount_id, CourseRepo $courseRepo)
    {
        $this->authorize("manage", Discount::class);
        $courses = $courseRepo->allCourseBylatest();
        $discount = $this->discountRepo->findOrFail($discount_id);
        return view("Discount::edit", compact("discount", "courses"));
    }

    public function update(UpdateDiscountRequest $request, $discount_id)
    {
        $this->authorize("manage", Discount::class);
        $this->discountRepo->update($request->all(), $discount_id);
        showFeedbacks();
        return redirect()->route("discount.index");
    }

    public function delete($discount_id)
    {
        $this->authorize("manage", Discount::class);
        $this->discountRepo->delete($discount_id);
        return AjaxResponses::successResponses();
    }

    public function check_discount_by_code(Request $request)
    {
        $discount = $this->discountRepo->CheckValidDiscountByCode($request->course, $request->code);

        if ($discount) {
            return DiscountServices::checkDiscountCodeSuccessAjaxReponse($request->course, $discount->percent);
        } else {
            return DiscountServices::checkDiscountCodeFailAjaxReponse();
        }
    }
}
