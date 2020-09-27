<?php

namespace Badzohreh\Course\Policies;

use Badzohreh\Course\Models\Course;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }


    public function manage(User $user)
    {

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }


    public function create(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;
    }

    public function edit(User $user, Course $course)
    {
        if (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) &&
                $user->id == $course->user_id) || $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES))
            return true;
        return null;
    }


    public function change_status_confirmation(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;
    }

    public function delete(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;
    }
}
