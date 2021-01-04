<?php

namespace Badzohreh\Media\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    protected $namespace = 'Badzohreh\Media\Http\Controllers';

    public function register()
    {

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . "./../Routes/media-routes.php");
        $this->loadMigrationsFrom(__DIR__ . '/../DataBase/Migrations');
        $this->mergeConfigFrom(__DIR__ . "./../Config/MediaFile.php", "MediaFile");

    }


    public function boot()
    {

    }
}
