<?php

namespace Badzohreh\User\Mail;

use Badzohreh\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $code;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$code)
    {
        //
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('User::mails.send-forgot-password-mail')
            ->subject("کد فراموشی سایت وب آموز");
    }
}
