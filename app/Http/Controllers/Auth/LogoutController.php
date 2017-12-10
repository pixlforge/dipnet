<?php

namespace Dipnet\Http\Controllers\Auth;

use Dipnet\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        auth()->logout();
        return redirect()->route('index');
    }
}
