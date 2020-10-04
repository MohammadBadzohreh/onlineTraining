<?php

namespace Badzohreh\Course\Models;

use Badzohreh\Media\Models\Media;
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


    static $CONFIRMATION_STATUS = [self::PENDING_CONFIRMATION_STATUS,self::ACCEPTED_CONFIRMATION_STATUS,self::REJECTED_CONFIRMATION_STATUS];



    public function getTeacherAttributes()
    {
        return $this->teacher();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, "teacher_id", "id");
    }


    public function banner()
    {
        return $this->belongsTo(Media::class, "banner_id", "id");
    }

    public function seassons()
    {
        return $this->hasMany(Season::class,"course_id","id");
    }


}
