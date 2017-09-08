<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();

        return redirect()
            ->route('profile')
            ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez dès à présent effectuer des commandes!')
            ->with('level', 'success');
    }
}