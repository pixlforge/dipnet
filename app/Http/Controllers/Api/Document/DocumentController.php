<?php

namespace App\Http\Controllers\Api\Document;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentsCollection;

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
     * Fetch documents.
     *
     * @return DocumentsCollection
     */
    public function index()
    {
        return new DocumentsCollection(Document::with('media', 'article')->latest()->paginate(25));
    }
}
