<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\RegistrationEmailConfirmation;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();

        if (!$user) {
            return redirect()
                ->route('index')
                ->with('flash', 'La confirmation de votre compte a échoué. Le code de confirmation est invalide.')
                ->with('level', 'danger');
        }

        $user->confirm();

        if (auth()->check()) {
            return redirect()
                ->route('profile.index')
                ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez dès à présent effectuer des commandes!')
                ->with('level', 'success');
        } else {
            return redirect()
                ->route('login')
                ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez dès à présent vous y connecter.')
                ->with('level', 'success');
        }
    }

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
