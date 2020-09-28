<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 31/08/2020
 * Time: 12:47 AM
 */

namespace Badzohreh\User\Providers;

use Badzohreh\User\Database\Seeds\UserTableSeeder;
use Badzohreh\User\Models\User;
use Badzohreh\User\Policies\UserPollicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set("auth.providers.users.model", User::class);

        \DatabaseSeeder::$seeders[] = UserTableSeeder::class;

        Gate::policy(User::class, UserPollicy::class);


    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/user-route.php");
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");
        $this->loadFactoriesFrom(__DIR__ . "/../Database/Factories");
        $this->loadViewsFrom(__DIR__ . "./../Resources/Views", 'User');

    }
}