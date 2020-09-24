<?php


Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    $user = auth()->user();
    $user->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES);
    return auth()->user()->permissions;

});








