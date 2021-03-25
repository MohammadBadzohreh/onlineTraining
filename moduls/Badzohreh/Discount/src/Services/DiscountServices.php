<?php

namespace Badzohreh\Discount\Services;

use Badzohreh\Course\Repositories\CourseRepo;
use Illuminate\Http\Response;

class DiscountServices
{
    public static function getDiscountAmount(int $price, int $percent)
    {
        return ($price * $percent) / 100;
    }

    public static function formattedDiscountAmount(int $price, int $percent)
    {
        return number_format(self::getDiscountAmount($price, $percent));
    }

    public static function checkDiscountCodeSuccessAjaxReponse($courseId, $percent)
    {
        $courseRepo = new CourseRepo();
        $course = $courseRepo->findById($courseId);
        $discountAmount = DiscountServices::getDiscountAmount($course->price, $percent);
        $finalPrice = $course->price - $discountAmount;
        $response = [
            "status" => "valid",
            "discountPercent" => $percent,
            "discountAmount" => number_format($discountAmount),
            "payable" => number_format($finalPrice),
        ];
        return response()->json($response)->setStatusCode(Response::HTTP_OK);
    }

    public static function checkDiscountCodeFailAjaxReponse()
    {
        $response = [
            "status" => "invalid",
        ];
        return response()->json($response)->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

}
