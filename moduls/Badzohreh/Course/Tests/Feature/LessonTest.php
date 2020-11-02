<?php

namespace Badzohreh\Course\Tests\Feature;

use Badzohreh\Category\Models\Category;
use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Models\Lesson;
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

    public function test_admin_can_see_create_lesson_page()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->get(route("lessons.create", $course->id))->assertOk();
    }

    public function test_super_admin_can_see_create_lesson_page()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->get(route("lessons.create", $course->id))->assertOk();
    }

    public function test_normal_user_can_not_see_lesson_page()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        $this->get(route("lessons.create", $course->id))->assertStatus(403);
    }

    public function test_user_can_see_create_lesson_for_it_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->get(route("lessons.create", $course->id))->assertOk();
    }

    public function test_user_can_not_see_create_lesson_for_onther_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->get(route("lessons.create", $course->id))->assertStatus(403);
    }

    public function test_admin_can_store_lesson()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("ass.mp4", 10240),
            "is_free" => 1,
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::count());
    }

    public function test_super_admin_can_store_lesson()
    {

        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("ass.mp4", 10240),
            "is_free" => 1

        ])->assertRedirect();
        $this->assertEquals(1, Lesson::count());
    }

    public function test_normal_user_can_not_store_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("skfd;.mp4", 10240),
            "is_free" => 1,
        ])->assertStatus(403);
        $this->assertEquals(0, Lesson::count());
    }

    public function test_teacher_can_create_lesson_for_own_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->assertEquals(1, Course::count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("ssmfld.mp4"),
            "is_free" => 1
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::count());
    }

    public function test_teacher_can_not_create_lesson_for_onther_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("ssmfld.mp4"),
            "is_free" => 1
        ])->assertStatus(403);
        $this->assertEquals(0, Lesson::count());
    }

    public function test_super_admin_can_see_edit_page()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("mfkdv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::query()->count());
        $lesson = Lesson::query()->first();
        $this->get(route("lesson.edit", [$course->id, $lesson->id]))->assertOk();
    }

    public function test_admin_can_see_edit_page()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("mfkdv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::query()->count());
        $lesson = Lesson::query()->first();
        $this->get(route("lesson.edit", [$course->id, $lesson->id]))->assertOk();
    }


    public function test_teacher_can_edit_it_lessons_course()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("mfkdv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::query()->count());
        $lesson = Lesson::query()->first();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->get(route("lesson.edit", [$course->id, $lesson->id]))->assertOk();
    }

    public function test_teacher_can_not_edit_onther_lessons_course()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("mfkdv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::query()->count());
        $lesson = Lesson::query()->first();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->get(route("lesson.edit", [$course->id, $lesson->id]))->assertStatus(403);
    }

    public function test_normal_user_can_not_edit_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("mfkld.mp4", 10240),
            "is_free" => 1,
        ])->assertRedirect();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        $lesson = Lesson::query()->first();
        $this->get(route("lesson.edit", [$course->id, $lesson->id]))->assertStatus(403);
    }

    public function test_admin_can_update_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->patch(route("lesson.update", [$course->id, $lesson->id]), [
            "title" => "karimi",
            "is_free" => 1,
        ])->assertRedirect();
        $this->assertEquals("karimi", Lesson::query()->first()->title);

    }

    public function test_super_admin_can_update_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->patch(route("lesson.update", [$course->id, $lesson->id]), [
            "title" => "karimi",
            "is_free" => 1,
        ])->assertRedirect();
        $this->assertEquals("karimi", Lesson::query()->first()->title);

    }

    public function test_teacher_can_update_lessons_it_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route("lesson.update", [$course->id, $lesson->id]), [
            "title" => "karimi",
            "is_free" => 1,
        ])->assertRedirect();
        $this->assertEquals("karimi", Lesson::query()->first()->title);

    }

    public function test_teacher_can_update_lessons_onther_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->patch(route("lesson.update", [$course->id, $lesson->id]), [
            "title" => "karimi",
            "is_free" => 1,
        ])->assertStatus(403);
        $this->assertEquals("mohammad", Lesson::query()->first()->title);

    }


    public function test_normal_user_can_not_update_course()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        $this->patch(route("lesson.update", [$course->id, $lesson->id]), [
            "title" => "karimi",
            "is_free" => 1,
        ])->assertStatus(403);
        $this->assertEquals("mohammad", Lesson::query()->first()->title);
    }

    public function test_admin_can_accpet_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->patch(route("lesson.accpet", 1))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::query()->find(1)->confirmation_staus);
    }

    public function test_super_admin_can_accept_lesson()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->patch(route("lesson.accpet", 1))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::query()->find(1)->confirmation_staus);
    }

    public function test_normal_user_can_not_accept_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->actAsUser();
        $this->patch(route("lesson.accpet", 1))->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
    }


//    reject
    public function test_admin_can_reject_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->patch(route("lesson.reject", 1))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::query()->find(1)->confirmation_staus);
    }

    public function test_super_admin_can_reject_lesson()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->patch(route("lesson.reject", 1))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::query()->find(1)->confirmation_staus);
    }

    public function test_normal_user_can_not_reject_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
        $this->actAsUser();
        $this->patch(route("lesson.reject", 1))->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::query()->find(1)->confirmation_staus);
    }

//lock

    public function test_amin_can_lock_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
    }


    public function test_super_admin_can_lock_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
    }

    public function test_normal_user_can_not_lock_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->actAsUser();
        $this->patch(route("lesson.lock", 1))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
    }


//    unlock


    public function test_amin_can_unlock_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.unlock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
    }


    public function test_super_admin_can_unlock_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.unlock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
    }


    public function test_normal_user_can_not_unlock_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
        $this->actAsUser();
        $this->patch(route("lesson.unlock", 1))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
    }

    public function test_teacher_can_not_lock_lesson()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route("lesson.lock", 1))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);

    }


    public function test_teacher_can_not_unlock_lesson()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::query()->find(1)->status);
        $this->patch(route("lesson.lock", 1))->assertOk();
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route("lesson.unlock", 1))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_CLOSED, Lesson::query()->find(1)->status);

    }

    public function test_super_admin_can_delete_lessons()
    {
        $this->acAsSuperAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->delete(route("lesson.destroy", [1, 1]))->assertOk();
        $this->assertEquals(0, Lesson::query()->count());
    }


    public function test_admin_can_delete_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->delete(route("lesson.destroy", [1, 1]))->assertOk();
        $this->assertEquals(0, Lesson::query()->count());
    }

    public function test_teacher_can_delete_own_lesssons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        $course->teacher_id = auth()->id();
        $course->save();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->delete(route("lesson.destroy", [1, 1]))->assertOk();
        $this->assertEquals(0, Lesson::query()->count());
    }


    public function test_teacher_can_not_delete_nother_course_lessons()
    {
        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSE);
        $this->delete(route("lesson.destroy", [1, 1]))->assertStatus(403);
        $this->assertEquals(1, Lesson::query()->count());
    }

    public function test_normal_user_can_not_delete_lessons()
    {

        $this->actAsAdmin();
        $course = $this->create_course();
        $this->post(route("lessons.store", $course->id), [
            "title" => "mohammad",
            "lesson-upload" => UploadedFile::fake()->create("wrfdmv.mp4", 10240),
            "is_free" => 1
        ])->assertRedirect();
        $lesson = Lesson::query()->first();
        $this->assertEquals(1, Lesson::query()->count());
        $this->actAsUser();
        $this->delete(route("lesson.destroy", [1, 1]))->assertStatus(403);
        $this->assertEquals(1, Lesson::query()->count());

    }



//unlock


//===================
    private function actAsAdmin()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
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
