<?php

namespace Badzohreh\Discount\Providers;

use Badzohreh\Discount\Models\Discount;
use Badzohreh\Discount\Policies\DiscountPolicy;
use Badzohreh\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    private $namespace = "Badzohreh\Discount\Http\Controllers";

    public function register()
    {
        Route::middleware(["web", "auth"])
            ->namespace($this->namespace)
            ->group(__DIR__ . "./../Routes/discount-routes.php");
        $this->loadMigrationsFrom(__DIR__ . "./../Database/Migrations");
        $this->loadViewsFrom(__DIR__ . "./../Resources/Views", "Discount");

        Gate::policy(Discount::class, DiscountPolicy::class);
    }

    public function boot()
    {

        config()->set("sidebar.items.discounts", [
            'icon' => 'i-discounts',
            'title' => 'تخفیف ها',
            'link' => route("discount.index"),
            'permission' => [
                Permission::PERMISSION_SUPER_ADMIN,
                Permission::PERMISSION_MANAGE_DISCOUNT,
            ],
        ]);
    }
}
