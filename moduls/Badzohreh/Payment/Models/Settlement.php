<?php

namespace Badzohreh\Payment\Models;

use Badzohreh\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $guarded = [];
    const STATUS_PENDING = "pending";
    const STATUS_SATTELED = "satteled";
    const STATUS_CANCELLED = "cancelled";
    const STATUS_REJECTED = "rejected";

    public static $STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_SATTELED,
        self::STATUS_CANCELLED,
        self::STATUS_REJECTED,
    ];

    protected $casts = [
        "from" => "json",
        "to" => "json",
    ];

    public function sattlementClassColor()
    {
        if ($this->status == self::STATUS_PENDING) return "text-warning";
        if ($this->status == self::STATUS_SATTELED) return "text-success";
        if ($this->status == self::STATUS_CANCELLED) return "text-error";
        if ($this->status == self::STATUS_REJECTED) return "text-error";
    }

//    relations

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
