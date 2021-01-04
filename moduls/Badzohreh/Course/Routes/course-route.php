<?php
Route::group(['namespace' => 'Badzohreh\Course\Http\Controllers',
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource("course", CourseController::class);
    $router->patch("/course_accpet/{course}", "CourseController@accpet")->name("course.change.accept");
    $router->patch("/course_reject/{course}", "CourseController@reject")->name("course.change.rejected");

    $router->patch("/course_lock/{course}", "CourseController@lock")->name("course.change.locked");

    $router->post("/course/{course}/buy", "CourseController@buy")->name("course.buy");
    $router->get("/course/{course}/download", "CourseController@downloadLinks")->name("download.course");
});
