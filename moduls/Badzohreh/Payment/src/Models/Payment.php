<?php

namespace Badzohreh\Payment\Models;

use Badzohreh\User\Models\User;
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

    public function buyer()
    {
        return $this->belongsTo(User::class, "buyer_id", "id");
    }


    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id", "id");
    }

}
