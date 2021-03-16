<?php

namespace Badzohreh\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSattlementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|string|min:3",
            "amount" => "required|numeric|min:10000|max:" . auth()->user()->balance,
            "cart_number" => "required|numeric"
        ];
    }

    public function attributes()
    {
        return [
            "amount" => "مقدار",
            "cart_number" => "شماره کارت"
        ];
    }
}
