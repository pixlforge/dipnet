<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\DocumentRequest;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Document::class);

        return view('documents.create');
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
            'file_name' => request('file_name'),
            'file_path' => request('file_path'),
            'mime_type' => request('mime_type'),
            'quantity' => request('quantity'),
            'rolled_folded_flat' => request('rolled_folded_flat'),
            'length' => request('length'),
            'width' => request('width'),
            'nb_orig' => request('nb_orig'),
            'free' => request('free'),
            'format_id' => request('format_id'),
            'delivery_id' => request('delivery_id'),
            'article_id' => request('article_id')
        ]);

        return redirect()->route('documents');
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $this->authorize('view', $document);

        return view('documents.show', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
