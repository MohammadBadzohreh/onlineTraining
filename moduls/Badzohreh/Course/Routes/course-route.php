<?php
Route::group(['namespace'=>'Badzohreh\Course\Http\Controllers',
    'middleware'=>['web','auth','verified']],function ($router){
    $router->resource("course", CourseController::class);

});