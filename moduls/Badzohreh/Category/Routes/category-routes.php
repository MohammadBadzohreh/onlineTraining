<?php


Route::group(['namespace'=>'Badzohreh\Category\Http\Controllers'],function ($router){
   $router->resource("categories", CategoryController::class);
});