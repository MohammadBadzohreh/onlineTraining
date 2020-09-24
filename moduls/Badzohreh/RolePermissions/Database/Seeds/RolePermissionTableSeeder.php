<?php


namespace Badzohreh\RolePermissions\Database\Seeds;
use Badzohreh\RolePermissions\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        foreach (Permission::$PERMISSIONS as $PERMISSION) {

            Permission::findOrCreate($PERMISSION);
        }


        Role::findOrCreate("teacher")->givePermissionTo("teach");

    }
}
