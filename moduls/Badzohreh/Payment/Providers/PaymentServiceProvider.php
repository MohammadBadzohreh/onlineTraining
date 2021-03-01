<?php

namespace Badzohreh\Payment\Providers;

use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Badzohreh\RolePermissions\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    private $namespace = "Badzohreh\Payment\Http\Controllers";

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . "./../Database/Migrations");
        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(__DIR__ . "./../Routes/payment-routes.php");
        $this->loadViewsFrom(__DIR__."./../Resources/Views","Payment");
        $this->loadJsonTranslationsFrom(__DIR__.'./../Resources/Lang');
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();

        });

        config()->set("sidebar.items.payments", [
            'icon' => 'i-transactions',
            'title' => 'تراکنش ها',
            'link' => route("payments.index"),
            'permission' => [
                Permission::PERMISSION_MANAGE_PAYMENTS
            ],
        ]);

        config()->set("sidebar.items.purchases", [
            'icon' => 'i-my__purchases',
            'title' => 'خرید های من',
            'link' => route("purchases.index"),
            'permission' => [
                Permission::PERMISSION_MANAGE_PAYMENTS
            ],
        ]);

    }

}
