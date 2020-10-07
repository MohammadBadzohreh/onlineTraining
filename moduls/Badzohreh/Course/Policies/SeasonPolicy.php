<?php

namespace Badzohreh\Course\Policies;

use Badzohreh\Course\Models\Season;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeasonPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Season $season)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) &&
            $season->course->teacher_id == $user->id) {
            return true;
        }
    }

    public function changeConfirmation_status(User $user , Season $season)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
    }


}
