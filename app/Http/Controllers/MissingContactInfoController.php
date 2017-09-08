<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissingContactInfoController extends Controller
{
    /**
     * MissingContactInfoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('missing.contact');
    }
}
