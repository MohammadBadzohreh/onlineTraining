<?php

Route::group(['namespace' => 'Badzohreh\User\Http\Controllers',
    'middleware' => 'web'], function ($router) {

//    user email routes


    Route::resource("users",UserController::class);
    Route::delete("/{user}/giveRole/{role}","UserController@giveRole")->name("give.role.user");

    $router->post("user/{user}/add-role","UserController@addRole")->name("add.role");

    Route::post("email/resend", "Auth\VerificationController@resend")
        ->name("verification.resend")
        ->middleware('auth');

    Route::post("email/verify", "Auth\VerificationController@verify")
        ->name("verification.verify");

    Route::get("email/verify", "Auth\VerificationController@show")
        ->name("verification.notice")
        ->middleware('auth');
//    login routes

    Route::post("login", "Auth\LoginController@login");

    Route::get("login", "Auth\LoginController@showLoginForm")
        ->name("login");

//    register

    Route::post("register", "Auth\RegisterController@register")
        ->name("register");

    Route::get("register", "Auth\RegisterController@showRegistrationForm")
        ->name("register");
//    logout
    Route::post("logout", "Auth\LoginController@logout")
        ->name("logout");

//reset password

    Route::get("password/reset", "Auth\ForgotPasswordController@showVerifyCodeRequestForm")
        ->name("password.request");

    Route::get("password/reset/send", "Auth\ForgotPasswordController@sendVerifyCodeEmail")
        ->name("password.sendVerifyCodeEmail");

    Route::post("password/reset/check", "Auth\ForgotPasswordController@checkResetPassword")
        ->middleware('throttle:5,1')
        ->name("reset.password.check");


    Route::get("/password/change","Auth\ResetPasswordController@showResetForm")
        ->middleware("auth")
        ->name("password.showResetForm");

    Route::post("/change/passowrd",
        "Auth\ResetPasswordController@changePassowrd")
        ->name("password.update");
});





