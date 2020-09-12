<?php


Route::group(['namespace'=>'Badzohreh\Category\Http\Controllers',
    'middleware'=>['web','auth','verified']],function ($router){
   $router->resource("categories", CategoryController::class);
});