<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 31/08/2020
 * Time: 12:47 AM
 */

namespace Badzohreh\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'./../Routes/dashboard_routes.php');
        $this->loadViewsFrom(__DIR__."./../Resources/views",'Dashboard');

    }
}