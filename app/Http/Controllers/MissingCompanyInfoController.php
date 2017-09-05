<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissingCompanyInfoController extends Controller
{
    public function index()
    {
        return view('missing.company');
    }

    public function update()
    {
    }
}
