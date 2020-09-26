<?php

namespace moduls\Badzoreh\Category\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_super_admin_can_see_category_panel()
    {
        $this->actAsSuperAdmin();
        $this->get(route("categories.index"))->assertOk();
    }



    public function test_super_admin_can_create_category()
    {
        $this->actAsSuperAdmin();
       $this->post(route("categories.store"),[
           "title"=>$this->faker->word,
           "slug"=>$this->faker->word,
       ]);
       $this->assertEquals(1,Category::all()->count());
    }

    public function test_super_admin_can_edit_categories()
    {
        $title="mohammad";
        $this->actAsSuperAdmin();
        $this->create_category();
        $this->assertEquals(1,Category::all()->count());
        $this->assertEquals(0,Category::where(['title'=>$title])->count());
        $this->patch(route("categories.update",1),[
            "title"=>$title,
            "slug"=>"msfdflddvmvl"
        ]);
        $this->assertEquals(1,Category::where(['title'=>$title])->count());
    }
    public function test_super_admin_can_delete_category()
    {
        $this->actAsSuperAdmin();
        $this->create_category();
        $this->assertEquals(1,Category::all()->count());
        $this->delete(route("categories.destroy",1));
        $this->assertEquals(0,Category::all()->count());
    }


    public function test_permitted_user_can_see_category_panel()
    {
        $this->act_as_admin();
        $this->get(route("categories.index"))->assertOk();
    }
    public function test_not_permitted_user_can_not_see_category_panel()
    {
        $this->actAsUser();
        $this->get(route("categories.index"))->assertStatus(403);
    }
    public function test_permitted_user_can_create_category()
    {
        $this->act_as_admin();
        $this->create_category();
        $this->assertEquals(1,Category::all()->count());
    }
    public function test_not_permitted_user_can_not_create_category()
    {
        $this->actAsUser();
        $this->create_category();
        $this->assertEquals(0,Category::all()->count());
    }

    public function test_permitted_user_can_edit_category(){

        $title = "mohammad";
        $this->act_as_admin();
        $this->create_category();
        $this->assertEquals(0,Category::where(["title"=>$title])->count());
        $this->patch(route("categories.update",1),[
            "title"=>$title,
            "slug"=>"asasssass",
        ]);
        $this->assertEquals(1,Category::where(["title"=>$title])->count());
    }

    public function test_permitted_user_can_delete_category()
    {
        $this->act_as_admin();
        $this->create_category();
        $this->assertEquals(1,Category::all()->count());
        $this->delete(route("categories.destroy",1));
        $this->assertEquals(0,Category::all()->count());
    }






    private function actAsUser(){
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);

    }
    private function act_as_admin(){
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORY);
    }


    private function actAsSuperAdmin()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);

    }
    private function create_category(){

         $this->post(route("categories.store"),[
            "title"=>$this->faker->word,
            "slug"=>$this->faker->word
        ]);

    }
}
