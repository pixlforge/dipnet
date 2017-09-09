<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
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
            ->route('profile')
            ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez dès à présent effectuer des commandes!')
            ->with('level', 'success');
    }
}