<?php

namespace Badzohreh\Category\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_authenticated_user_can_see_categories_panel()
    {
        $this->activeAsAdmin();
        $this->assertAuthenticated();

    }

    public function test_authenticated_user_can_create_category()
    {
        $this->activeAsAdmin();
        $this->create_category();
        $this->assertEquals(1, Category::all()->count());
    }


    public function test_authenticated_user_can_edit_category()
    {
        $this->activeAsAdmin();
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
        $this->create_category();
        $this->assertEquals(1, Category::all()->count());
        $this->delete(route("categories.destroy", 1));
        $this->assertEquals(0, Category::all()->count());
    }

    private function activeAsAdmin()
    {
        $this->actingAs(factory(User::class)->create());

    }

    private function create_category()
    {
        $this->post(route("categories.store"), [
            'title' => $this->faker->word,
            'slug' => $this->faker->word,
        ]);
    }
}
