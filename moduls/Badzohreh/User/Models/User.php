<?php

namespace Badzohreh\User\Models;

use Badzohreh\User\Notifications\resetPasswordNotification;
use Badzohreh\User\Notifications\sendForgotPasswordCodeNotification;
use Badzohreh\User\Notifications\sendVerificationCodeNotification;
use Badzohreh\User\Notifications\VerifyMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
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


}
