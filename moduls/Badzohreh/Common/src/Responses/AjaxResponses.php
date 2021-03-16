<?php


namespace Badzohreh\Common\Responses;

use Illuminate\Http\Response;
class AjaxResponses
{

    public static function successResponses()
    {
        return response()->json(['message'=>'عملیات با موفقیت انجام شد.'],
            Response::HTTP_OK);
    }

    public static function failResponses()
    {
        return response()->json(['message'=>'خطا در عملیات.'],
            Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}