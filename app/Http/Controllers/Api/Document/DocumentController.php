<?php

namespace App\Http\Controllers\Api\Document;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentsCollection;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        return new DocumentsCollection(Document::latest()->paginate(25));
    }
}
