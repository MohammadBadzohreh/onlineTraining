<?php


Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    \Spatie\Permission\Models\Permission::create([
        "name"=>"manage permisions",
    ]);
    $user = auth()->user();
    $user->givePermissionTo('manage permisions');
    return auth()->user()->permissions;

});



