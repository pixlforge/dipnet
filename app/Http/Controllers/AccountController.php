<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account()
    {
        return view('account.details');
    }

    public function contact()
    {
        return view('account.contact');
    }

    public function company()
    {
        return view('account.company');
    }
}
