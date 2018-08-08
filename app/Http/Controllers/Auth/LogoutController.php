<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Logout the user and redirect him to the home page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        auth()->logout();
        return redirect()->route('index');
    }
}
