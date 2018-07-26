<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contact()
    {
        return view('account.contact');
    }

    public function company()
    {
        return view('account.company');
    }

    public function update(UpdateProfileRequest $request)
    {
        $request->user()->username = $request->username;
        $request->user()->email = $request->email;

        if ($request->has('password') && $request->password !== null) {
            $request->user()->password = bcrypt($request->password);
        }

        $request->user()->save();

        return response(null, 200);
    }
}
