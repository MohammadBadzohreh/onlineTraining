<?php

Route::group(['namespace'=>'Badzohreh\User\Http\Controllers','middleware'=>'web'],function ($router){
    Auth::routes(['verify' => true]);
});





