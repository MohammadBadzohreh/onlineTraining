<?php

namespace Badzohreh\Discount\Rules;

use Illuminate\Contracts\Validation\Rule;

use Morilog\Jalali\Jalalian;

class ValidDateRule implements Rule
{


    public function passes($attribute, $value)
    {
        try {
            Jalalian::fromFormat("Y/m/d H:i", $value)->toCarbon();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function message()
    {
        return 'لطفا یک تاریخ معتبر را وارد کنید.';
    }
}
