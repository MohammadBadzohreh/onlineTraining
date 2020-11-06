<?php

namespace Badzohreh\Front\Providers;

use Badzohreh\Category\Repositories\CategoryRepo;
use Badzohreh\Course\Repositories\CourseRepo;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . "./../Routes/front-routes.php");
        $this->loadViewsFrom(__DIR__ . "./../Resources/Views", "Front");
        view()->composer("Front::layouts.navbar", function ($view) {
            $categories = (new CategoryRepo())->tree();
            $view->with(compact("categories"));
        });

        view()->composer("Front::layouts.lastest-course",function ($view){
            $latest_course = (new CourseRepo())->latest_course();
            $view->with(compact("latest_course"));
        });

    }

    public function boot()
    {
    }
}