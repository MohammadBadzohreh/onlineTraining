<?php

Route::group(['namespace' => 'Badzohreh\User\Http\Controllers',
    'middleware' => ['web','auth']],function ($router){
    Route::resource("users", UserController::class);
    Route::post("logout", "Auth\LoginController@logout")
        ->name("logout");
    $router->post("user/{user}/add-role", "UserController@addRole")->name("add.role");
    Route::delete("/{user}/giveRole/{role}", "UserController@giveRole")->name("give.role.user");
    Route::patch("{user}/manualConfirm", "UserController@manualConfirm")->name("users.manualConfirm");
    Route::post("/userProfileImage", "UserController@userProfileImage")->name("userProfileImage");
    Route::post("user/profile", "UserController@updateProfile")->name("users.profile")->middleware("verified");
    Route::get("user/profile", "UserController@profile")->name("profile");
    Route::get("/profile/{username}", "UserController@viewProfile")->name("viewProfile");
    Route::post("email/resend", "Auth\VerificationController@resend")
        ->name("verification.resend");
});

Route::group(['namespace' => 'Badzohreh\User\Http\Controllers',
    'middleware' => 'web'], function ($router) {
    Route::post("email/verify", "Auth\VerificationController@verify")
        ->name("verification.verify");
    Route::post("login", "Auth\LoginController@login");
    Route::get("email/verify", "Auth\VerificationController@show")
        ->name("verification.notice");
    Route::get("login", "Auth\LoginController@showLoginForm")
        ->name("login");
    Route::post("register", "Auth\RegisterController@register")
        ->name("register");
    Route::get("register", "Auth\RegisterController@showRegistrationForm")
        ->name("register");
    Route::get("password/reset", "Auth\ForgotPasswordController@showVerifyCodeRequestForm")
        ->name("password.request");
    Route::get("password/reset/send", "Auth\ForgotPasswordController@sendVerifyCodeEmail")
        ->name("password.sendVerifyCodeEmail");
    Route::post("password/reset/check", "Auth\ForgotPasswordController@checkResetPassword")
        ->middleware('throttle:5,1')
        ->name("reset.password.check");
    Route::get("/password/change", "Auth\ResetPasswordController@showResetForm")
        ->middleware("auth")
        ->name("password.showResetForm");
    Route::post("/change/passowrd",
        "Auth\ResetPasswordController@changePassowrd")
        ->name("password.update");
});




