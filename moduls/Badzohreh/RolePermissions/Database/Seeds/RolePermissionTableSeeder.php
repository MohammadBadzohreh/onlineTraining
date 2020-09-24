<?php


namespace Badzohreh\RolePermissions\Database\Seeds;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\RolePermissions\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{

    public function run()
    {
        foreach (Permission::$PERMISSIONS as $PERMISSION) {
            Permission::findOrCreate($PERMISSION);
        }
        foreach (Role::$ROLES as $ROLE=>$PERMISSIONS) {
            Role::findOrCreate($ROLE)->givePermissionTo($PERMISSION);
        }
    }
}
