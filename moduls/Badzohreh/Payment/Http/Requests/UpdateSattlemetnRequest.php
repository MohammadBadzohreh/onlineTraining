<?php

namespace Badzohreh\Payment\Http\Requests;

use Badzohreh\Payment\Models\Settlement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSattlemetnRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "from" => "required|array",
            "to" => "required|array",
            "to.name" => "required_if:status," . Settlement::STATUS_SATTELED,
            "to.cart_number" => "required_if:status," . Settlement::STATUS_SATTELED,
            "from.name" => "required",
            "from.cart_number" => "required",
            "status" => ["required", Rule::in(Settlement::$STATUSES)],
            "amount" => "required|numeric",
        ];
    }

    public function attributes()
    {
        return [
            "status" => "وضعیت پرداخت",
            "satteled" => "تسویه شده",
            "to.name" => "نام صاحب حساب فرستنده",
            "to.cart_number" => "شماره صاحب حساب فرستنده",
        ];
    }


}
