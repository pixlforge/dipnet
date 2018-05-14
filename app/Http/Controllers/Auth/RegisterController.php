<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
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
        $user = new User;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->confirmation_token = User::generateConfirmationToken($request->email);

        if ($request->is_solo) {
            $user->is_solo = true;
        }

        $user->save();

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
