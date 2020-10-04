<?php


use Badzohreh\RolePermissions\Models\Role;

Route::get('/', function () {
    return view('index');
});


Route::get("/test",function (){
    $user = auth()->user();
    $user->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_TEACH);
    $user->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);
    $user->assignRole(\Badzohreh\RolePermissions\Models\Role::ROLE_TEACHER);
    return $user->roles;

});

Route::get("addRole",function (){
    Role::findOrCreate("writer")->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES);

});


Route::get("per",function (){
})->name("user.permissions");








