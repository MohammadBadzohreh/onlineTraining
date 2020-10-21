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

    $router->get("{course}/lesson/{lesson}/edit","LessonController@edit")->name("lesson.edit");
    $router->patch("{course}/lesson/{lesson}/update","LessonController@update")->name("lesson.update");

    $router->patch("{course}/lesson/accept-all","LessonController@accpetAll")->name("lesson.accpetAll");
    $router->patch("{course}/lesson/accept-selected","LessonController@acceptSelected")->name("lesson.accpetSelected");
    $router->patch("{course}/lesson/reject-selected","LessonController@rejectSelected")->name("lesson.rejectSelected");

});