<?php
namespace Badzohreh\Course\Providers;

use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'./../Routes/course-route.php');
        $this->loadMigrationsFrom(__DIR__.'./../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__."./../Resources/Lang");
        $this->loadViewsFrom(__DIR__.'./../Resources/views',"Course");
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang',"Course");
    }

    public function boot()
    {
        config()->set("sidebar.items.course",[
            'icon'=>'i-courses',
            'title'=>'دوره ها',
            'link'=>route("course.index")
        ]);
    }
}