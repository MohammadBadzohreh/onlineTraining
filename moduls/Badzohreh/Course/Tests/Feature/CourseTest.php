<?php

namespace Badzohreh\Course\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\Course\Models\Course;
use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function test_permitted_user_can_see_course_panel()
    {
        $this->actAsAdmin();
        $this->get(route("course.index"))->assertOk();
    }

    public function test_not_permitted_user_can_not_see_course_panel()
    {
        $this->actAsUser();
        $this->get(route("course.index"))->assertStatus(403);
    }

    public function test_super_admin_can_see_category_panel()
    {
        $this->acAsSuperAdmin();
        $this->get(route("course.index"))->assertOk();
    }

    public function test_permitted_user_can_see_creae_panel()
    {
        $this->actAsAdmin();
        $this->get(route("course.create"))->assertOk();
    }


    public function test_normal_user_can_see_creae_panel()
    {
        $this->actAsUser();
        $this->get(route("course.create"))->assertStatus(403);
    }

    public function test_super_admin_can_see_creae_panel()
    {
        $this->acAsSuperAdmin();
        $this->get(route("course.create"))->assertOk();
    }

    public function test_permitted_user_can_store_course()
    {

        $this->actAsAdmin();
        $this->create_categroy();
        $response = $this->post(route("course.store"),$this->CourseData());
        $response->assertRedirect(route("course.index"));
        $this->assertEquals(1, Course::count());
    }

    public function test_normal_user_can_not_store_course()
    {
        $this->actAsUser();
        $this->post(route("course.store"),$this->CourseData())->assertStatus(302);
    }

    public function test_super_admin_can_create_course()
    {
        $this->acAsSuperAdmin();
        $this->create_categroy();
        $response = $this->post(route("course.store"),$this->CourseData());
        $response->assertRedirect(route("course.index"));
        $this->assertEquals(1, Course::count());

    }


    public function test_permitted_user_can_see_course_edit_page()
    {
        $this->actAsAdmin();
        $this->create_course();
        $this->get(route("course.edit",1))->assertOk();
    }

    public function test_normal_user_can_not_see_edit_course_page()
    {
        $this->actAsAdmin();
        $this->create_course();
        $this->actAsUser();
        $this->get(route("course.edit",1))->assertStatus(403);
    }

    public function test_super_admin_can_see_edit_page()
    {
        $this->actAsAdmin();
        $this->create_course();
        $this->acAsSuperAdmin();
        $this->get(route("course.edit",1))->assertOk();
    }



//    edit page

//lock
//reject
//accept
//===================
    private function actAsAdmin()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    private function actAsUser()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function acAsSuperAdmin()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function create_categroy()
    {
        return Category::create([
            "title"=>"dmfkdlvnd",
            "slug"=>"scsfcsfsc",
        ]);
    }
    private function CourseData(){
        return [
            "category_id" => 1,
            "teacher_id" => 1,
            "title" => $this->faker->sentence(3),
            "slug" => $this->faker->sentence(3),
            "priority" => 132,
            "price" => 12300,
            "percent" => 70,
            "type" => Course::TYPE_CASH,
            "image" => UploadedFile::fake()->image('banner.jpg'),
            "status" => Course::STATUS_NOT_COMPELETED,
            "confirmation_status"=>Course::PENDING_CONFIRMATION_STATUS,
        ];
    }

    private function create_course()
    {
        $category = $this->create_categroy();
        return Course::create([
            "category_id" => $category->id,
            "teacher_id" => auth()->id(),
            "title" => $this->faker->sentence(3),
            "slug" => $this->faker->sentence(3),
            "priority" => 132,
            "price" => 12300,
            "percent" => 70,
            "type" => Course::TYPE_CASH,
            "status" => Course::STATUS_NOT_COMPELETED,
            "confirmation_status"=>Course::PENDING_CONFIRMATION_STATUS,
        ]);
    }

}
