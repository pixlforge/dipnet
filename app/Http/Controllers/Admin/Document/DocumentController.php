<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.documents.index');
    }
}
