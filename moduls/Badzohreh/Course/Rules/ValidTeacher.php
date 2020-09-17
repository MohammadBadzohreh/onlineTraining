<?php

namespace Badzohreh\Course\Ruls;

use Badzohreh\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidTeacher implements Rule
{

    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        $user=  resolve(UserRepo::class)->findById();
        return $user->hasPermissionTo('teach');
    }


    public function message()
    {
        return 'مدرس معتبر نمی باشد.';
    }
}
