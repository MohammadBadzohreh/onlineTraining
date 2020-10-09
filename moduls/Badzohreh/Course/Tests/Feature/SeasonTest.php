<?php

namespace Badzohreh\Course\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Models\Season;
use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SeasonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_admin_can_see_season_season_page()
    {
        $this->actAsAdmin();
        $this->create_course();
        $this->get(route("seassons.index", 1))->assertOk();
    }


    public function test_super_admin_can_see_season_season_page()
    {

        $this->actAsAdmin();
        $this->create_course();
        $this->get(route("seassons.index", 1))->assertOk();
    }


    public function test_not_permitted_user_can_not_see_season_page()
    {
        $this->actAsAdmin();
        $this->create_course();
        $this->assertEquals(1, Course::count());
        $this->actAsUser();
        $this->get(route("seassons.index", 1))->assertStatus(403);
    }

    public function test_admin_can_create_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store", $course->id), [
            "title" => "sadslssa",
        ]);
        $this->assertEquals(1, Season::count());
    }

    public function test_super_admin_can_create_season()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store", $course->id), [
            "title" => "sadslssa",
        ]);
        $this->assertEquals(1, Season::count());
    }

    public function test_teacher_has_own_course_permission_can_create_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route("seassons.store", $course->id), [
            "title" => "mohammad",
        ]);
        $this->assertEquals(1, Season::count());
    }

    public function test_normal_user_can_not_create_season()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        $this->post(route("seassons.store", $course->id), [
            "title" => "mohammad",
        ])->assertStatus(403);
        $this->assertEquals(0, Season::count());
    }

    public function test_normal_user_can_not_create_onother_course_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->assertEquals(1, Course::count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->post(route("seassons.store", $course->id), [
            "title" => "mohammad",
        ])->assertStatus(403);
        $this->assertEquals(0, Season::count());
    }

    public function test_super_admin_can_see_edit_season()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $season = $this->assertEquals(1,Season::count());
        $this->get(route("season.edit", 1))->assertOk();
    }

    public function test_admin_can_see_edit_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $season = $this->assertEquals(1,Season::count());
        $this->get(route("season.edit", 1))->assertOk();
    }

    public function test_user_has_permission_manage_course_can_see_edit_own_course()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Course::count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->get(route("season.edit", 1))->assertOk();
    }

    public function test_normal_user_can_not_see_edit_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Course::count());
        $this->actAsUser();
        $this->get(route("season.edit", 1))->assertStatus(403);
    }


    public function test_super_admin_can_update_season()
    {
        $this->acAsSuperAdmin();
        $course =$this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->patch(route("season.update",1),[
            "title"=>"karim"
        ]);
        $this->assertEquals(1,Season::count());
        $season  = Season::first();
        $this->assertEquals("karim",$season->title);
    }

    public function test_admin_can_update_season()
    {
        $this->actAsAdmin();
        $course =$this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->patch(route("season.update",1),[
            "title"=>"karim"
        ]);
        $this->assertEquals(1,Season::count());
        $season  = Season::first();
        $this->assertEquals("karim",$season->title);
    }


    public function test_teacher_can_edit_own_season()
    {
        $this->actAsAdmin();
        $course =$this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();

        $this->patch(route("season.update",1),[
            "title"=>"karim"
        ]);
        $this->assertEquals(1,Season::count());
        $season  = Season::first();
        $this->assertEquals("karim",$season->title);
    }

    public function test_normal_user_can_not_update_season()
    {
        $this->actAsAdmin();
        $course =$this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->actAsUser();
        $this->patch(route("season.update",1),[
            "title"=>"karim"
        ])->assertStatus(403);
        $this->assertEquals(1,Season::count());
        $season  = Season::first();
        $this->assertEquals("mohammad",$season->title);
    }

    public function test_teacher_can_not_update_onther_season()
    {
       $this->actAsAdmin();
       $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->patch(route("season.update",1),[
            "title"=>"karim"
        ])->assertStatus(403);
        $this->assertEquals("mohammad",Season::first()->title);


    }

    public function test_super_admin_can_accpet_season()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.accpet",1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_ACCEPTED,
            Season::first()->confirmation_status);

    }

    public function test_super_admin_can_reject_season()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.reject",1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_REJECTED,
            Season::first()->confirmation_status);
    }

    public function test_admin_can_accpet_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.accpet",1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_ACCEPTED,
            Season::first()->confirmation_status);

    }

    public function test_admin_can_reject_season()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.reject",1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_REJECTED,
            Season::first()->confirmation_status);
    }

    public function test_normal_user_can_not_chnage_confirmation_season(){
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->actAsUser();
        $this->patch(route("season.accpet",1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.reject",1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
    }
    public function test_teacher_can_not_chnage_confirmation_season(){
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route("season.accpet",1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
        $this->patch(route("season.reject",1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING,
            Season::first()->confirmation_status);
    }


    public function test_super_admin_can_change_status(){
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
        $this->patch(route("season.closed",1))->assertOk();
        $this->assertEquals(Season::STATUS_CLOSED,
            Season::first()->status);
        $this->patch(route("season.opened",1))->assertOk();
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
    }


    public function test_admin_can_change_status(){
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
        $this->patch(route("season.closed",1))->assertOk();
        $this->assertEquals(Season::STATUS_CLOSED,
            Season::first()->status);
        $this->patch(route("season.opened",1))->assertOk();
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
    }



    public function test_not_permitte_user_can_not_change_status(){
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1,Course::count());
        $this->post(route("seassons.store",$course->id),[
            'title'=>"mohammad"
        ]);
        $this->assertEquals(1,Season::count());
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route("season.closed",1))->assertStatus(403);
        $this->assertEquals(Season::STATUS_OPENED,
            Season::first()->status);
    }

//    =========
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
