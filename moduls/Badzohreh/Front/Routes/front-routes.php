<?php


use Illuminate\Support\Facades\Route;

Route::group(["middleware"=>"web","namespace"=>"Badzohreh\Front\Http\Controllers"],function ($router){
    $router->get("/","FrontController@index")->name('index');


});