<?php


use Illuminate\Support\Facades\Route;

Route::group(["middleware"=>"web","namespace"=>"Badzohreh\Front\Http\Controllers"],function ($router){
    $router->get("/","FrontController@index")->name('index');
    $router->get("/c-{slug}","FrontController@singleCourse")->name('single-course');
    $router->get("tutor/{username}","FrontController@tutor")->name("tutor");

});
