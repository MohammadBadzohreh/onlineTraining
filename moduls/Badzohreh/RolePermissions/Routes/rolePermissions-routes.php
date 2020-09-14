<?php



Route::group(['namespace'=>'Badzohreh\RolePermissions\Http\Controllers',
    'middleware'=>['web','auth','verified']],function ($router){
    $router->resource("permissions", RolePermissionsController::class )
        ->middleware("permission:manage permisions");
});