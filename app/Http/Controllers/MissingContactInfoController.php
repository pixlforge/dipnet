<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissingContactInfoController extends Controller
{
    public function index()
    {
        return view('missing.contact');
    }

    public function update()
    {
    }
}
