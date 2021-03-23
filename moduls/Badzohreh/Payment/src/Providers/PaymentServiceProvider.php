<?php

namespace Badzohreh\Payment\Providers;

use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Badzohreh\Payment\Models\Settlement;
use Badzohreh\Payment\Policies\PaymentPolicy;
use Badzohreh\Payment\Policies\SettlementPolicy;
use Badzohreh\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
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

        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(__DIR__ . "./../Routes/settlement-routes.php");

        $this->loadMigrationsFrom(__DIR__ . "./../Database/Migrations");

        $this->loadViewsFrom(__DIR__ . "./../Resources/Views", "Payment");
        $this->loadJsonTranslationsFrom(__DIR__ . './../Resources/Lang');


        Gate::policy(PaymentPolicy::class, PaymentPolicy::class);

        Gate::policy(Settlement::class, SettlementPolicy::class);


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
        ]);

        config()->set("sidebar.items.settlement_pruchases", [
            'icon' => 'i-checkout__request',
            'title' => 'تسویه',
            'link' => route("settlement.create"),
            'permission' => [
                Permission::PERMISSION_TEACH
            ],
        ]);

        config()->set("sidebar.items.settlements", [
            'icon' => 'i-checkouts',
            'title' => 'تسویه حساب ها',
            'link' => route("settlement.index"),
            'permission' => [
                Permission::PERMISSION_MANAGE_SETTLEMENTS,
                Permission::PERMISSION_TEACH,
            ],
        ]);

    }

}
