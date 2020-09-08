<?php

namespace Badzohreh\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\changePasswordRequest;
use Badzohreh\User\Http\Requests\checkFrogotPasswordRequest;
use Badzohreh\User\Http\Requests\checkResetPasswordRequest;
use Badzohreh\User\Http\Requests\forgotEmailRequest;
use Badzohreh\User\Http\Requests\sendForgotPasswordEmailRequest;
use Badzohreh\User\Http\Requests\sendResetPasswordVerifyCodeRequest;
use Badzohreh\User\Models\User;
use Badzohreh\User\Notifications\sendForgotPasswordCodeNotification;
use Badzohreh\User\Repositories\UserRepo;
use Badzohreh\User\Services\VerifyService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showVerifyCodeRequestForm()
    {
        return view("User::Front.auth.passwords.email");
    }

    public function sendVerifyCodeEmail(sendResetPasswordVerifyCodeRequest $request)
    {

        $user = resolve(UserRepo::class)->findgByEmail($request->email);

        if ($user && ! VerifyService::has($user->id)) {
            $user->sendResetPasswordNotifications();
        }
        return view("User::Front.auth.passwords.forgot-verification-code");
    }


    public function checkResetPassword(checkResetPasswordRequest $request)
    {
        $user = resolve(UserRepo::class)->findgByEmail($request->email);


        if (!VerifyService::check($user->id, $request->verification_code)) {
            return back()
                ->withErrors(["verification_code" => "کد وارد شده معتبر نمی باشد."]);
        }
        auth()->loginUsingId($user->id);

        return redirect()->route("password.showResetForm");



    }


}
