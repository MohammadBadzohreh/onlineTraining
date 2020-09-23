<?php


Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    $user = auth()->user();
    $user->givePermissionTo('manage categories');
    return auth()->user()->permissions;

});








