<?php

namespace Badzohreh\User\Mail;

use Badzohreh\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public  $user;


    public function __construct(User $user,int $code)
    {

        $this->code = $code;
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('User::mails.verify-code')
            ->subject("کد فعالسازی وب آموز");
    }
}
