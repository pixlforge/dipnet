<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\Contact;
use App\Http\Controllers\Controller;
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
//        $this->middleware('guest')->except('updateContact', 'updateCompany');
        $this->middleware('guest');
    }

    /**
     * Show the registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
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

        $this->sendConfirmationEmail($user);

        return Auth::login($user, true);
    }

    /**
     * @param $user
     */
    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}
