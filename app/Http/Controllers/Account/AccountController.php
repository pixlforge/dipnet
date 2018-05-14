<?php

namespace App\Http\Controllers\Account;

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
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request)
    {
        $request->validate([]);

//        if ($request->password === null) {
//            $request->validate([
//                'username' => 'required|string|min:3|max:255',
//                'email' => 'required|string|email|unique:users|max:255'
//            ]);
//
//            $request->user()->username = $request->username;
//            $request->user()->email = $request->email;
//            $request->user()->save();
//
//            return response([], 200);
//        }
//
//        if ($request->password) {
//            $request->validate([
//                'username' => 'required|string|min:3|max:255',
//                'email' => 'required|string|email|unique:users|max:255',
//                'password' => 'required|string|min:6|confirmed'
//            ]);
//
//            $request->user()->username = $request->username;
//            $request->user()->email = $request->email;
//            $request->user()->password = bcrypt($request->password);
//            $request->user()->save();
//
//            return response([], 200);
//        }
    }
}