<?php


//for test
Route::get("/test", function () {
    event(new \App\Events\SuccessfulPayment(new \Badzohreh\Payment\Models\Payment()));
});


Route::get("/getPermissions", function () {
    $user = auth()->user();
    dd($user->permissions);
});











