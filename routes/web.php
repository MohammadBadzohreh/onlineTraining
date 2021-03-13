<?php

Route::get("rolesss",function (){

    auth()->user()->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);

});


Route::get("/getPermissions", function () {
    $user = auth()->user();
    dd($user->permissions);
});











