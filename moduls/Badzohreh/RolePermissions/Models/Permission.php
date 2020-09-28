<?php

namespace Badzohreh\RolePermissions\Models;
class Permission extends \Spatie\Permission\Models\Permission
{

    const PERMISSION_MANAGE_CATEGORY = "manage categories";
    const PERMISSION_MANAGE_ROLE_PERMISSION = "manage role_permissions";
    const PERMISSION_MANAGE_OWN_COURSE = 'manage own course';
    const PERMISSION_SUPER_ADMIN = "super admin";
    const PERMISSION_MANAGE_COURSES = 'manage courses';
    const PERMISSION_TEACH = "teach";
    const PERMISSION_MANAGE_USERS = "manage users";
    static $PERMISSIONS = [
        self::PERMISSION_MANAGE_CATEGORY,
        self::PERMISSION_MANAGE_ROLE_PERMISSION,
        self::PERMISSION_MANAGE_COURSES,
        self::PERMISSION_MANAGE_OWN_COURSE,
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_TEACH,
        self::PERMISSION_MANAGE_USERS,
    ];

}