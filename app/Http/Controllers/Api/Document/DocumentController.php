<?php

namespace Dipnet\Http\Controllers\Api\Document;

use Dipnet\Document;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\DocumentsCollection;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return DocumentsCollection
     */
    public function index()
    {
        return new DocumentsCollection(Document::latest()->paginate(25));
    }
}
