<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * ProfilesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Profile
     */
    public function profile()
    {
        $user = User::where('id', auth()->id())->firstOrFail([
            'username', 'email', 'email_validated', 'contact_id',
            'company_id', 'last_login_at', 'created_at'
        ]);

        return view('profiles.profile', compact([
            'user'
        ]));
    }
}
