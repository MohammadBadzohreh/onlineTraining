<?php


namespace Badzohreh\Category\Responses;

use Illuminate\Http\Response;
class AjaxResponses
{

    public static function successResponses()
    {
        return response()->json(['message'=>'عملیات با موفقیت انجام شد.'],
            Response::HTTP_OK);
    }

}