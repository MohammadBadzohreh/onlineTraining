<?php

namespace Badzohreh\User\Policies;

use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPollicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;
    }
    public function addRole(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;
    }
    public function removeRole(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;

    }
    public function update(User $user){
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;
    }
    public function delete(User $user){
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;
    }

    public function manaualConfirm(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;
        return null;

    }
}
