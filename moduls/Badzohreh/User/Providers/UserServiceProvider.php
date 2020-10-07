<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 31/08/2020
 * Time: 12:47 AM
 */

namespace Badzohreh\User\Providers;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Database\Seeds\UserTableSeeder;
use Badzohreh\User\Http\Middleware\StoreUserIp;
use Badzohreh\User\Models\User;
use Badzohreh\User\Policies\UserPollicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/user-route.php");
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");
        $this->loadFactoriesFrom(__DIR__ . "/../Database/Factories");
        $this->loadViewsFrom(__DIR__ . "./../Resources/Views", 'User');
        $this->loadJsonTranslationsFrom(__DIR__."./../Resources/Lang");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);
        config()->set("auth.providers.users.model", User::class);
        \DatabaseSeeder::$seeders[] = UserTableSeeder::class;
        Gate::policy(User::class, UserPollicy::class);

    }

    public function boot()
    {
        config()->set("sidebar.items.users", [
            'icon' => 'i-users',
            'title' => 'کاربران',
            'link' => route("users.index"),
            'permission'=>Permission::PERMISSION_MANAGE_USERS
        ]);
        $this->app->booted(function (){
            config()->set("sidebar.items.profile", [
                'icon' => 'i-users',
                'title' => 'اطلاعات کاربری',
                'link' => route("profile")
            ]);
        });

    }
}