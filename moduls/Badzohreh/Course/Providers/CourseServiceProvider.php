<?php
namespace Badzohreh\Course\Providers;

use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'./../Routes/course-route.php');
        $this->loadMigrationsFrom(__DIR__.'./../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'./../Resources/views',"Course");
    }

    public function boot()
    {

    }
}