<?php

namespace Badzohreh\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Badzohreh\User\Http\Requests\verificationCodeRequest;
use Badzohreh\User\Services\VerifyService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('User::Front.auth.verify');
    }

    public function verify(verificationCodeRequest $request)
    {

        if (!VerifyService::check(auth()->id(), $request->verification_code))
            return back()->withErrors(['verification_code'=>'کد وارد شده درست نیست.']);

        auth()->user()->markEmailAsVerified();
        return redirect('/home');
    }


}
