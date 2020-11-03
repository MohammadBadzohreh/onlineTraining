<?php
namespace Badzohreh\Front\Providers;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__."./../Routes/front-routes.php");
        $this->loadViewsFrom(__DIR__."./../Resources/Views","Front");
    }
    public function boot(){

    }
}