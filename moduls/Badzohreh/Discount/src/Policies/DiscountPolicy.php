<?php

namespace Badzohreh\Discount\Policies;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;


    public function manange(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_DISCOUNT)) return true;
    }
}
