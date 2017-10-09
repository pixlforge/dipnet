<?php

namespace App\Http\Controllers\Auth;

use App\Mail\RegistrationEmailConfirmation;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RegisterConfirmationController extends Controller
{
    /**
     * RegisterConfirmationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Confirm the user registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();

        if (! $user) {
            return redirect()
                ->route('index')
                ->with('flash', 'La confirmation de votre compte a échoué. Le code de confirmation est invalide.')
                ->with('level', 'danger');
        }

        $user->confirm();

        return redirect()
            ->route('profile.index')
            ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez dès à présent effectuer des commandes!')
            ->with('level', 'success');
    }

    /**
     * Update the user's confirmation token and send the confirmation email again.
     */
    public function update()
    {
        $user = User::whereEmail(auth()->user()->email)->first();

        if ($user->confirmation_token !== null) {
            $user->confirmation_token = User::generateConfirmationToken($user->email);
            $user->save();

            Mail::to($user)
                ->queue(new RegistrationEmailConfirmation($user));
        }
    }
}