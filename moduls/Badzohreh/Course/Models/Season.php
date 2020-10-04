<?php

namespace Badzohreh\Course\Models;

use Badzohreh\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{

    protected $guarded = [];
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PENDING = 'pending';

    static $STATUSES = [self::STATUS_PENDING,self::STATUS_REJECTED,self::STATUS_ACCEPTED];
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
