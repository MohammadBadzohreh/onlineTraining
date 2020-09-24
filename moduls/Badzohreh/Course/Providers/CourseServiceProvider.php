<?php

namespace Badzohreh\Course\Providers;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Policies\CoursePolicy;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . './../Routes/course-route.php');
        $this->loadMigrationsFrom(__DIR__ . './../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . "./../Resources/Lang");
        $this->loadViewsFrom(__DIR__ . './../Resources/views', "Course");
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', "Course");
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::before(function (User $user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
    }

    public function boot()
    {
        config()->set("sidebar.items.course", [
            'icon' => 'i-courses',
            'title' => 'دوره ها',
            'link' => route("course.index")
        ]);
    }
}