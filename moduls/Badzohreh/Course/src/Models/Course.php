<?php

namespace Badzohreh\Course\Models;

use Badzohreh\Category\Models\Category;
use Badzohreh\Course\Repositories\CourseRepo;
use Badzohreh\Media\Models\Media;
use Badzohreh\Payment\Models\Payment;
use Badzohreh\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    const TYPE_FREE = 'free';
    const TYPE_CASH = "cash";
    static $TYPES = [self::TYPE_FREE, self::TYPE_CASH];
    const STATUS_COMPELETED = "completed";
    const STATUS_NOT_COMPELETED = "not-completed";
    const STATUS_LOCKED = "locked";
    static $STATUSES = [self::STATUS_COMPELETED, self::STATUS_NOT_COMPELETED, self::STATUS_LOCKED];

    const ACCEPTED_CONFIRMATION_STATUS = 'accepted';
    const REJECTED_CONFIRMATION_STATUS = 'rejected';
    const PENDING_CONFIRMATION_STATUS = 'pending';


    static $CONFIRMATION_STATUS = [self::PENDING_CONFIRMATION_STATUS, self::ACCEPTED_CONFIRMATION_STATUS, self::REJECTED_CONFIRMATION_STATUS];


    public function getTeacherAttributes()
    {
        return $this->teacher();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, "teacher_id", "id");
    }

    public function seassons()
    {
        return $this->hasMany(Season::class, "course_id", "id");
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, "course_id", "id");
    }

    public function lessonCount()
    {
        return (new CourseRepo())->lessonCount($this->id);
    }


    public function shortLink()
    {
        return route("single-course", $this->id);
    }


    public function banner()
    {
        return $this->belongsTo(Media::class, "banner_id", "id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");

    }


    public function getTime()
    {
        return $this->lessons
            ->where("confirmation_staus", Lesson::CONFIRMATION_STATUS_ACCEPTED)
            ->sum("time");
    }

    public function getFormattedTime()
    {
        $time = $this->getTime();
        $hour = round($time / 60) < 10 ? "0" . round($time / 60) : round($time / 60);
        $minute = $time % 60 < 10 ? "0" . $time % 60 : $time % 60;
        return $hour . ":" . $minute . ":00";
    }

    public function format_price()
    {
        return number_format($this->price);

    }

    public function path()
    {
        return route("single-course", $this->id . "-" . $this->slug);
    }


    public function payments()
    {
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function students()
    {
        return $this->belongsToMany(User::class, "course_user", "course_id", "user_id");
    }

    public function hasStudent($student_id)
    {
        return resolve(CourseRepo::class)->hasStudent($this, $student_id);
    }

    public function getDiscountPercent()
    {
//        todo
        return 0;
    }

    public function getDiscountAmont()
    {
//        todo
        return 0;
    }

    public function getFinalPrice()
    {
//        todo
        return $this->price - $this->getDiscountAmont();
    }


    public function downloadLinks()
    {
        $links = [];
        foreach ($this->lessons as $lesson) {
            $links[] = $lesson->downloadLink();
        }

        return $links;
    }


}
