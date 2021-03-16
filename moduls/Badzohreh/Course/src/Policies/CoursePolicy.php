<?php

namespace Badzohreh\Course\Policies;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Repositories\CourseRepo;
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

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) || $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
    }


    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) || $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
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

    public function detail(User $user, Course $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE)
            && $course->teacher_id == $user->id) {
            return true;
        }
        return null;
    }

    public function createSeason(User $user, Course $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE) &&
            $course->teacher_id == $user->id) {
            return true;
        }
        return null;
    }

    public function createLesson(User $user, Course $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE)
            && $course->teacher_id == $user->id) return true;
        return null;
    }

    public function accpetLessons(User $user, Course $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        return null;
    }

    public function change_confirmation_status(User $user, Course $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        return null;
    }

    public function download(User $user, Course $course)
    {
        if ($course->teacher_id === $user->id ||
            $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ||
            $course->hasStudent($user->id)
        ) {
            return true;
        }
        return false;
    }
}
