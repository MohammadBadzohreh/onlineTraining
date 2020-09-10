<?php

Route::group(['namespace'=>'Badzohreh\Dashboard\Http\Controllers'],function ($router){

    $router->get('/home', 'DashboardController@index')->name('home');
});


