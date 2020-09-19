<?php


Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    \Spatie\Permission\Models\Permission::create([
        "name"=>"manage role_permissions",
    ]);
    $user = auth()->user();
    $user->givePermissionTo('manage permisions');
    return auth()->user()->permissions;

});


Route::get("/add-user",function (){
  return bcrypt("Mohammad100%");
});



