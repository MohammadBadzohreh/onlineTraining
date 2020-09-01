<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 31/08/2020
 * Time: 12:47 AM
 */

namespace Badzohreh\User\Providers;

use Badzohreh\User\Models\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set("auth.providers.users.model",User::class);
    }
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/user-route.php");
        $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        $this->loadFactoriesFrom(__DIR__."/../Database/Factories");
        $this->loadViewsFrom(__DIR__."./../Resources/Views",'User');

    }
}