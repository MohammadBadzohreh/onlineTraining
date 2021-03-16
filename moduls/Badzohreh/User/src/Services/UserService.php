<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 09/09/2020
 * Time: 01:51 AM
 */

namespace Badzohreh\User\Services;


use Badzohreh\User\Models\User;

class UserService
{

    public static function changePassword(User $user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
    }

}