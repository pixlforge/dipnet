<?php

namespace App\Http\Controllers\Auth;

use App\Invitation;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmailConfirmation;
use App\Http\Requests\Register\RegisterAccountRequest;

class RegisterController extends Controller
{
    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Request $request
     */
    public function index()
    {
        return view('auth.register', [
            'token' => request()->query('token')
        ]);
    }

    /**
     * Create a new user account.
     *
     * @param RegisterAccountRequest $request
     */
    public function store(RegisterAccountRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'confirmation_token' => User::generateConfirmationToken($request->email)
        ]);

        $invitation = Invitation::where('email', $request->email)->first();

        if ($invitation) {
            $invitation->delete();
            return Auth::login($user, true);
        }

        $this->sendConfirmationEmail($user);

        return Auth::login($user, true);
    }

    /**
     * Send a confirmation email to a newly registered user.
     *
     * @param $user
     */
    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}
