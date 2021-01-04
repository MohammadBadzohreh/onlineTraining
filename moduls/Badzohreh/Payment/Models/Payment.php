<?php

namespace Badzohreh\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    const STATUS_PENDING = "pending";
    const STATUS_CANCELED = "canceled";
    const STATUS_ACCEPTED = "accepted";
    const STATUS_FAIL = "fail";
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CANCELED,
        self::STATUS_ACCEPTED,
        self::STATUS_FAIL,
    ];

    public function paymentable()
    {
        return $this->morphTo("paymentable");
    }
}
