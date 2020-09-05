<?php

Route::group(['namespace' => 'Badzohreh\User\Http\Controllers',
    'middleware' => 'web'], function ($router) {
    Auth::routes(['verify' => true]);

    $router->post("email/verify", "Auth\VerificationController@verify")
        ->name("verification.verify");

});





