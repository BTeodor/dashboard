<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\ResetedPasswordViaEmail;
use App\Events\User\RequestedPasswordResetEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordRemindRequest;
use App\Mailers\UserMailer;
use App\Models\User;
use Password;
use App\Http\Requests\Auth\PasswordResetRequest;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Create a new password controller instance.
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword() {
        return view('frontend.auth.password.remind');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordRemindRequest $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function sendPasswordReminder(PasswordRemindRequest $request, UserMailer $mailer) {
        $user = User::where('email', $request->get('email'))->first();

        $token = Password::getRepository()->create($user);

        $mailer->sendPasswordReminder($user, $token);

        event(new RequestedPasswordResetEmail($user));

        return redirect()->to('password/remind')
            ->with('success', trans('app.password_reset_email_sent'));
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return \Illuminate\Http\Response
     * @throws NotFoundHttpException
     */
    public function getReset($token = null) {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('frontend.auth.password.reset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param PasswordResetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(PasswordResetRequest $request) {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect('login')->with('success', trans($response));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password) {
        $user->password = $password;
        $user->save();

        event(new ResetedPasswordViaEmail($user));
    }
}
