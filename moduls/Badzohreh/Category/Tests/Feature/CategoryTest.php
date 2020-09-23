<?php

namespace Badzohreh\Category\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_has_manage_categories_permission_can_see_categories_panel()
    {
        $this->activeAsAdmin();
        Permission::findOrCreate("manage categories");
        auth()->user()->givePermissionTo("manage categories");
        $this->get(route("categories.index"))->assertOk();
    }

    public function test_user_has_not_manage_category_permission_can_not_see_categories_panel()
    {
        $this->activeAsAdmin();
        $this->get(route("categories.index"))->assertStatus(403);

    }

    public function test_user_has_manage_categories_permission_can_create_category()
    {
        $this->activeAsAdmin();
        Permission::findOrCreate("manage categories");
        auth()->user()->givePermissionTo("manage categories");
        $this->create_category();
        $this->assertEquals(1, Category::all()->count());
    }


    public function test_user_has_not_manage_categorories_can_not_create_category()
    {
        $this->activeAsAdmin();
        $response = $this->create_category();
        $response->assertStatus(403);
    }


    public function test_authenticated_user_can_edit_category()
    {
        $this->activeAsAdmin();
        Permission::findOrCreate("manage categories");
        auth()->user()->givePermissionTo("manage categories");
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
        Permission::findOrCreate("manage categories");
        auth()->user()->givePermissionTo("manage categories");
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
