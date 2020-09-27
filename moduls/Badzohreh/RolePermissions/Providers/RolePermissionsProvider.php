<?php


namespace Badzohreh\RolePermissions\Providers;

use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\RolePermissions\Models\Role;
use Badzohreh\RolePermissions\Policies\RolePermissionPolicy;
use Badzohreh\User\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RolePermissionsProvider extends ServiceProvider{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'./../Routes/rolePermissions-routes.php');
        $this->loadViewsFrom(__DIR__.'./../Resources/Views','RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__."/../Resources/Lang");
        \DatabaseSeeder::$seeders[]=RolePermissionTableSeeder::class;

        Gate::policy(Role::class,RolePermissionPolicy::class);
    }

    public function boot()
    {
        config()->set("sidebar.items.Rolepermissions",[
            'icon'=>'i-categories',
            'title'=>'نقش کاربری',
            'link'=>route("permissions.index")
        ]);
    }
}