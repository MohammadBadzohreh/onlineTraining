<?php

namespace Badzohreh\Course\Providers;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Models\Lesson;
use Badzohreh\Course\Models\Season;
use Badzohreh\Course\Policies\CoursePolicy;
use Badzohreh\Course\Policies\LessonPolicy;
use Badzohreh\Course\Policies\SeasonPolicy;
use Badzohreh\Payment\Providers\EventServiceProvider;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadRoutesFrom(__DIR__ . './../Routes/course-route.php');
        $this->loadRoutesFrom(__DIR__ . './../Routes/season-route.php');
        $this->loadRoutesFrom(__DIR__ . './../Routes/lessons-routes.php');
        $this->loadMigrationsFrom(__DIR__ . './../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . "./../Resources/Lang");
        $this->loadViewsFrom(__DIR__ . './../Resources/views', "Course");
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', "Course");
        Gate::before(function (User $user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Season::class, SeasonPolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);
    }

    public function boot()
    {
        config()->set("sidebar.items.course", [
            'icon' => 'i-courses',
            'title' => 'دوره ها',
            'link' => route("course.index"),
            'permission' => [
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_MANAGE_OWN_COURSE,
            ],
        ]);
    }
}
