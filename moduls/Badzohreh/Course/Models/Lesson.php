<?php

namespace Badzohreh\Course\Models;

use Badzohreh\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

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

    public function media()
    {
        return $this->belongsTo(Media::class, "media_id", "id");
    }

    public function durationTime()
    {
        $hour = round($this->time / 60) < 10 ? "0" . round($this->time / 60) : round($this->time / 60);
        $minute = $this->time % 60 < 10 ? "0" . $this->time % 60 : $this->time % 60;
        return $hour . ":" . $minute . ":00";
    }

    public function path()
    {
        return $this->course->path() . "?lesson=l-" . $this->id . "-" . $this->slug;
    }

    public function downloadLink()
    {
        if ($this->media_id){
            return URL::temporarySignedRoute("media.download", now()->addDay(), $this->media_id);
        }
    }


}
