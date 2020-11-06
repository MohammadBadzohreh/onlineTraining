<?php

namespace Badzohreh\User\Models;

use Badzohreh\Course\Models\Course;
use Badzohreh\Course\Models\Season;
use Badzohreh\Media\Models\Media;
use Badzohreh\User\Notifications\resetPasswordNotification;
use Badzohreh\User\Notifications\sendForgotPasswordCodeNotification;
use Badzohreh\User\Notifications\sendVerificationCodeNotification;
use Badzohreh\User\Notifications\VerifyMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasFactory;
    protected $guarded = [];
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BAN = 'ban';
    static $STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMail());
    }


    public function sendResetPasswordNotifications()
    {
        $this->notify(new resetPasswordNotification());

    }


    public function banner()
    {
        return $this->belongsTo(Media::class, "image_id", "id");
    }

    public function profilePath()
    {
        return $this->username ? route("viewProfile", $this->username) : route("viewProfile", 'username');
    }

    public function seassons()
    {
        return $this->hasMany(Season::class, "user_id", "id");
    }

    public function courses()
    {
        return $this->hasMany(Course::class, "teacher_id", "id");
    }

    public function getThumbAttribute()
    {
        if ($this->banner) {
            return $this->banner->thumb;
        }
        return "/panel/img/pro.jpg";
    }
}
