<?php

namespace Badzohreh\Course\Models;

use Badzohreh\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{

    protected $guarded = [];
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $CONFIRMATION_STATUS= [self::CONFIRMATION_STATUS_PENDING,self::CONFIRMATION_STATUS_ACCEPTED,self::CONFIRMATION_STATUS_REJECTED];


    const STATUS_OPENED = "opened";
    const STATUS_CLOSED = "closed";

    static $STATUSES =[self::STATUS_OPENED,self::STATUS_CLOSED];

    public function course()
    {
        return $this->belongsTo(Course::class,"course_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function lessons(){
        return $this->hasMany(Lesson::class,"season_id","id");
    }
}
