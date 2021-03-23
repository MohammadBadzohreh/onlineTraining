<?php

namespace Badzohreh\Discount\Models;

use Badzohreh\Course\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        "expire_at" => "date"
    ];

    const DISCOUNT_ALL_TYPE = "all";
    const DISCOUNT_SINGLE_TYPE = "single";
    static $TYPES = [
        self::DISCOUNT_ALL_TYPE,
        self::DISCOUNT_SINGLE_TYPE,
    ];

    public function courses()
    {
        return $this->morphedByMany(Course::class, "discountable", "discountables");
    }


    public static function booted()
    {
        static::deleting(function ($discount) {
            $discount->courses()->sync([]);
        });
    }


}
