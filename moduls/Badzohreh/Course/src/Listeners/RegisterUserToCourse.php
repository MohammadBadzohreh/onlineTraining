<?php

namespace Badzohreh\Course\Listeners;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Repositories\CourseRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterUserToCourse
{

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        if ($event->payment->paymentable_type = Course::class) {
            resolve(CourseRepo::class)
                ->addStudentToCourse($event->payment->paymentable, $event->payment->buyer_id);
        }
    }
}
