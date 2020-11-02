<?php

namespace Badzohreh\RolePermissions\Tests\Feature;

use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\RolePermissions\Models\Role;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_permissions_panel()
    {
        $this->actAsAdmin();
        $this->get(route("permissions.index"))->assertOk();
    }


    public function test_super_admin_can_see_permissions_panel()
    {
        $this->acAsSuperAdmin();
        $this->get(route("permissions.index"))->assertOk();
    }


    public function test_normal_user_can_not_see_permissions_panel()
    {
        $this->actAsUser();
        $this->get(route("permissions.index"))->assertStatus(403);
    }

    public function test_permitted_user_can_create_role()
    {
        $this->actAsAdmin();
        $this->post(route("permissions.store"), [
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES) + 1, Role::count());
    }



    public function test_super_admin_can_create_role()
    {
        $this->acAsSuperAdmin();
        $this->post(route("permissions.store"), [
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES) + 1, Role::count());
    }

    public function test_normal_user_can_not_create_role()
    {
        $this->actAsUser();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertStatus(403);

    }

    public function test_super_admin_can_edit_roles_page()
    {
        $this->acAsSuperAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES) +1,Role::count());
        $this->get(route("permissions.edit",1))->assertOk();

    }



    public function test_permitted_user_can_edit_roles_page()
    {
        $this->actAsAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES) +1,Role::count());
        $this->get(route("permissions.edit",1))->assertOk();

    }



    public function test_normal_user_can_edit_roles_page()
    {
        $this->actAsAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->actAsUser();
        $this->get(route("permissions.edit",1))->assertStatus(403);
    }


    public function test_permitted_user_can_delete_role_permissions()
    {
        $this->actAsAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES)+1,Role::count());
        $this->delete(route("permissions.destroy",1))->assertOk();
        $this->assertEquals(count(Role::$ROLES),Role::count());

    }


    public function test_super_admin_can_delete_role_permissions()
    {
        $this->acAsSuperAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->assertEquals(count(Role::$ROLES)+1,Role::count());
        $this->delete(route("permissions.destroy",1))->assertOk();
        $this->assertEquals(count(Role::$ROLES),Role::count());

    }


    public function test_normal_user_can_delete_role_permissions()
    {
        $this->actAsAdmin();
        $this->post(route("permissions.store"),[
            "name" => "sksadsaad",
            "permissions" => [
                Permission::PERMISSION_MANAGE_ROLE_PERMISSION,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route("permissions.index"));
        $this->actAsUser();
        $this->assertEquals(count(Role::$ROLES)+1,Role::count());
        $this->delete(route("permissions.destroy",1))->assertStatus(403);
        $this->assertEquals(count(Role::$ROLES)+1,Role::count());

    }





//    ===============
    private function actAsAdmin()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSION);
    }

    private function actAsUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function acAsSuperAdmin()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

}
