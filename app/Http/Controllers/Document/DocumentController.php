<?php

namespace Dipnet\Http\Controllers\Document;

use Dipnet\Order;
use Dipnet\Delivery;
use Dipnet\Document;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\DocumentRequest;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
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
    public function store(Order $order, Delivery $delivery, Request $request)
    {
        $this->authorize('touch', $order);

        $uploadedFile = $request->file('file');

        $document = $this->storeDocument($order, $delivery, $uploadedFile);

        Storage::disk('local')->putFileAs(
            'orders/' . $order->reference . '/' . $delivery->reference,
            $uploadedFile,
            $document->filename
        );

        return response($document, 200);
    }

    /**
     * Store a new Document model.
     *
     * @param Order $order
     * @param Delivery $delivery
     * @param UploadedFile $uploadedFile
     * @return Document
     */
    protected function storeDocument(Order $order, Delivery $delivery, UploadedFile $uploadedFile)
    {
        $document = new Document;

        $document->fill([
            'filename' => $uploadedFile->getClientOriginalName(),
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
            'finish' => 'roulé',
            'delivery_id' => $delivery->id,
        ]);

        $document->delivery()->associate($delivery);
        $document->save();

        return $document;
    }

    /**
     * Delete a document.
     *
     * @param Order $order
     * @param Delivery $delivery
     * @param Document $document
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order, Delivery $delivery, Document $document)
    {
        $this->authorize('touch', $order);

        $document->delete();

        return response(null, 204);
    }
}