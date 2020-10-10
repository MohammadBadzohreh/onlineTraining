<?php

namespace Badzohreh\Media\Providers;
use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../DataBase/Migrations');
        $this->mergeConfigFrom(__DIR__."./../Config/MediaFile.php","MediaFile");
    }

    public function boot()
    {
        
    }
}