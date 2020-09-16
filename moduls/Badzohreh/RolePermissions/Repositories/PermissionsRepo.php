<?php
namespace Badzohreh\RolePermissions\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionsRepo{

    public function all()
    {
        return Permission::all();
    }
}