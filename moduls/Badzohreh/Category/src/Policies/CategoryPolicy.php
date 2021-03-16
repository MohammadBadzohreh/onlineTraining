<?php

namespace Badzohreh\Category\Policies;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function manage(User $user)
    {
        return false;
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
    }
}
