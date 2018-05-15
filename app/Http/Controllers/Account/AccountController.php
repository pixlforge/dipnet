<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
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

    /**
     * Update account info.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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