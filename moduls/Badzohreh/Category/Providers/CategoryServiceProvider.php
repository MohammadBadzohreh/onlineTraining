<?php
namespace Badzohreh\Category\Providers;
use Illuminate\Support\ServiceProvider;
class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__."/../Routes/category-routes.php");
        $this->loadViewsFrom(__DIR__."/../Resources/Views","Categories");
        $this->loadMigrationsFrom(__DIR__."/../DataBase/Migrations");
    }

    public function boot()
    {
        config()->set("sidebar.items.category",[
            'icon'=>'i-categories',
            'title'=>'دسته بندی',
            'link'=>route("categories.index")
        ]);
    }
}