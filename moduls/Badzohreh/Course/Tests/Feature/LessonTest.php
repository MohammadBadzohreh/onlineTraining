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
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function

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
            "title" => "dmfkdlvnd",
            "slug" => "scsfcsfsc",
        ]);
    }

    private function CourseData()
    {
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
            "confirmation_status" => Course::PENDING_CONFIRMATION_STATUS,
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
            "confirmation_status" => Course::PENDING_CONFIRMATION_STATUS,
        ]);
    }

}
