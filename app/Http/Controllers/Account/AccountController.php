<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('account.contact');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company()
    {
        return view('account.company');
    }

    /**
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
