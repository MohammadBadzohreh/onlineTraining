<?php

namespace Badzohreh\Course\Policies;

use Badzohreh\Course\Models\Lesson;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    public function changeConfirmation_status(User $user, Lesson $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES))
            return true;
        return null;
    }

    public function change_status(User $user, Lesson $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) && $lesson->course->user_id) {
            return true;
        }
        return null;
    }

    public function edit(User $user, Lesson $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) && $user->id == $lesson->course->teacher_id) {
            return true;
        }
        return null;
    }

}
