<?php
Route::group(['namespace'=>'Badzohreh\Course\Http\Controllers',
    'middleware'=>['web','auth','verified']],function ($router){

    $router->get("{course}/seassions","SeasonController@index")->name("seassons.index");
    $router->post("{course}/seassions","SeasonController@store")->name("seassons.store");
    $router->get("{season}/seassions/edit","SeasonController@edit")->name("season.edit");
    $router->patch("{season}/seassions/edit","SeasonController@update")->name("season.update");
    $router->patch("{season}/change-status/accept","SeasonController@accept")->name("season.accpet");
    $router->patch("{season}/change-status/reject","SeasonController@reject")->name("season.reject");
    $router->patch("{season}/change-status/open","SeasonController@open")->name("season.opened");
    $router->patch("{season}/change-status/close","SeasonController@close")->name("season.closed");

});