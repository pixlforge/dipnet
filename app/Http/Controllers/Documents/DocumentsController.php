<?php

namespace App\Http\Controllers\Documents;

use App\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;

class DocumentsController extends Controller
{
    /**
     * DocumentsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user.email.confirmed']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Document::class);

        $documents = Document::orderBy('file_name')
            ->get()
            ->toJson();

        return view('documents.index', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DocumentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $this->authorize('create', Document::class);

        Document::create([
            'file_name' => $request->file_name,
            'file_path' => $request->file_path,
            'mime_type' => $request->mime_type,
            'quantity' => $request->quantity,
            'rolled_folded_flat' => $request->rolled_folded_flat,
            'length' => $request->length,
            'width' => $request->width,
            'nb_orig' => $request->nb_orig,
            'free' => $request->free,
            'format_id' => $request->format_id,
            'delivery_id' => $request->delivery_id,
            'article_id' => $request->article_id
        ]);

        return redirect()->route('documents.index');
    }
}