<?php

namespace Badzohreh\Payment\Policies;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettlementPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function index(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_TEACH) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTLEMENTS))
            return true;
        return null;
    }


    public function create(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_TEACH)) return true;
        return null;
    }

    public function manage(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTLEMENTS)) return true;
        return null;

    }

}
