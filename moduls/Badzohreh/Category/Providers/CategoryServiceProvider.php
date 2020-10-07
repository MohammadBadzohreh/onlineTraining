<?php

namespace Badzohreh\Category\Providers;

use Badzohreh\Category\DataBase\Seeds\CategoryTableSeeder;
use Badzohreh\Category\Models\Category;
use Badzohreh\Category\Policies\CategoryPolicy;
use Badzohreh\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/category-routes.php");
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Categories");
        $this->loadMigrationsFrom(__DIR__ . "/../DataBase/Migrations");

        \DatabaseSeeder::$seeders  [] = CategoryTableSeeder::class;
        Gate::policy(Category::class,CategoryPolicy::class);
    }

    public function boot()
    {
        config()->set("sidebar.items.category", [
            'icon' => 'i-categories',
            'title' => 'دسته بندی',
            'link' => route("categories.index"),
            'permission'=>Permission::PERMISSION_MANAGE_CATEGORY,
        ]);
    }
}