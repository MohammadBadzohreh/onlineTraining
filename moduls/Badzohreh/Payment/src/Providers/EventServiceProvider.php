<?php


namespace Badzohreh\Payment\Providers;

use Badzohreh\Course\Listeners\RegisterUserToCourse;
use Badzohreh\Payment\Events\SuccessfulPayment;
use Badzohreh\Payment\Listeners\AddSellerShareToAcount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        SuccessfulPayment::class => [
            RegisterUserToCourse::class,
            AddSellerShareToAcount::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
