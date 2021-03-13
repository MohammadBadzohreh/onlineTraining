<?php

namespace Badzohreh\Payment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddSellerShareToAcount
{

    public function __construct()
    {
        //
    }


    public function handle($event)
    {
        if ($event->payment->seller) {
            $event->payment->seller->balance += $event->payment->seller_share;
            $event->payment->seller->save();
        }
    }
}
