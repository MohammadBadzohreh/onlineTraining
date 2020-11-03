<?php



//for test
Route::get("/test",function (){
    auth()->user()->givePermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_MANAGE_OWN_COURSE);
});


Route::get("/getPermissions",function (){
   $user = auth()->user();
    dd($user->permissions);
});











