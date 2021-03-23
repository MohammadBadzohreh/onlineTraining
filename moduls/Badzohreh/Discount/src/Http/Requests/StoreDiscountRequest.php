<?php

namespace Badzohreh\Discount\Http\Requests;

use Badzohreh\Discount\Models\Discount;
use Badzohreh\Discount\Rules\ValidDateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            "code" => "nullable|string|max:50|unique:discounts,code",
            "percent" => "required|numeric",
            "usage_limitation" => "nullable|numeric|min:1|max:100",
            "courses" => "nullable|array",
            "expire_at" => ["required", new ValidDateRule()],
            "type" => ["nullable", Rule::in(Discount::$TYPES)],
        ];
    }

    public function attributes()
    {
        return [
            "code" => "کد",
            "percent" => "درصد",
            "usage_limitation" => "محدویت افراد",
            "expire_at" => "انقضا",
            "type" => "نوع تخفیف"
        ];
    }
}
