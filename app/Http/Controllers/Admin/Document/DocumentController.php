<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.documents.index');
    }
}
