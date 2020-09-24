<?php

namespace Badzohreh\Category\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_category_panel()
    {
        $this->activeAsAdmin();

        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
        $this->get(route("categories.index"))->assertOk();
    }

    public function test_not_permitted_user_can_not_see_category_panel()
    {
        $this->activeAsAdmin();
        $this->get(route("categories.index"))->assertStatus(403);
    }

    public function test_permitted_user_can_create_category()
    {
        $this->activeAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
        $this->create_category();
        $this->assertEquals(1, Category::all()->count());
    }


    public function test_not_permitted_user_can_not_create_category()
    {
        $this->activeAsAdmin();
        $response = $this->create_category();
        $response->assertStatus(403);
    }


    public function test_authenticated_user_can_edit_category()
    {
        $this->activeAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
        $this->create_category();
        $this->put(route("categories.update", 1), [
            'title' => "php",
            'slug' => $this->faker->word
        ]);
        $this->assertEquals(1, Category::whereTitle("php")->count());
    }

    public function test_authtenticated_user_can_delete_category()
    {
        $this->activeAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
        $this->create_category();
        $this->assertEquals(1, Category::all()->count());
        $this->delete(route("categories.destroy", 1));
        $this->assertEquals(0, Category::all()->count());
    }

    private function activeAsAdmin()
    {
        return $this->actingAs(factory(User::class)->create());
    }

    private function create_category()
    {
        return $this->post(route("categories.store"), [
            'title' => $this->faker->word,
            'slug' => $this->faker->word,
        ]);
    }
}
