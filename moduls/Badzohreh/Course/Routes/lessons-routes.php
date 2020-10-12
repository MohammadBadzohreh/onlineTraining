<?php
Route::group(['namespace'=>'Badzohreh\Course\Http\Controllers',
    'middleware'=>['web','auth','verified']],function ($router){

    $router->get("{course}/course/create/lesson","LessonController@create")->name("lessons.create");
    $router->post("{course}/course/create/lesson","LessonController@store")->name("lessons.store");
    $router->delete("{course}/course/{lesson}/lesson/delete","LessonController@destroy")->name("lesson.destroy");
    $router->delete("course/lessons/delete","LessonController@deleteMultiple")
        ->name("delete.multiple.lessons");
    $router->patch("{lesson}/lessons/accept","LessonController@accpet")->name("lesson.accpet");
    $router->patch("{lesson}/lessons/reject","LessonController@reject")->name("lesson.reject");
    $router->patch("{lesson}/lessons/lock","LessonController@lock")->name("lesson.lock");
    $router->patch("{lesson}/lessons/unlock","LessonController@unlock")->name("lesson.unlock");
});