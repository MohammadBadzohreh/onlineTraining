<?php

namespace Badzohreh\Course\Models;

use Badzohreh\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $CONFIRMATION_STATUS = [self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_REJECTED];
    const STATUS_OPENED = "opened";
    const STATUS_CLOSED = "closed";
    static $STATUSES = [self::STATUS_OPENED, self::STATUS_CLOSED];

    public function course()
    {
        return $this->belongsTo(Course::class, "course_id", "id");
    }

    public function seasson()
    {
        return $this->belongsTo(Season::class, "season_id", "id");
    }

    public function getSeasonTitleAttribute()
    {
        return !is_null($this->seasson) ? $this->seasson->title : "__";
    }

    public function banner(){
        return $this->belongsTo(Media::class,"media_id","id");
    }
}
