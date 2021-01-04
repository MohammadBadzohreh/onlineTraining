<?php

namespace Badzohreh\Payment\Services;

use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Models\Payment;
use Badzohreh\Payment\Repositories\PaymentRepo;
use Badzohreh\User\Models\User;

class PaymentServices
{
    public static function generate($amount, $paymentable, User $user)
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($user->id)) return false;
        $gateway = resolve(Gateway::class);
        $invoice = $gateway->request($amount, $paymentable->title);
        if (is_array($invoice)) {
//            todo handle khata
        }
        if (!is_null($paymentable->percent)) {
            $seller_percent = $paymentable->percent;
            $seller_share = ($amount / 100) * $seller_percent;
            $site_share = $amount - $seller_share;
        } else {
            $seller_percent = $seller_share = 0;
            $site_share = $amount;
        }

        return resolve(PaymentRepo::class)->store([
            "buyer_id" => $user->id,
            "paymentable_id" => $paymentable->id,
            "paymentable_type" => get_class($paymentable),
            "amount" => $amount,
            "invoice_id" => $invoice,
            "getway" => $gateway->getName(),
            "status" => Payment::STATUS_PENDING,
            "seller_percent" => $seller_percent,
            "seller_share" => $seller_share,
            "site_share" => $site_share,

        ]);
    }
}
