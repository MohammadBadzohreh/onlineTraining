<?php


Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    $user = auth()->user();
    $user->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);
    return auth()->user()->permissions;

});








