<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissingCompanyInfoController extends Controller
{
    /**
     * MissingCompanyInfoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('missing.company');
    }
}
