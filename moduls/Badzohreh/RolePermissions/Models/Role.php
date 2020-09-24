<?php


namespace Badzohreh\RolePermissions\Models;


class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_TEACHER = 'teacher';
    static $ROLES = [
        self::ROLE_TEACHER => [
            Permission::PERMISSION_TEACH,
        ],
    ];
}