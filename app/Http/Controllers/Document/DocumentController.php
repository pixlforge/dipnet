<?php

namespace Dipnet\Http\Controllers\Document;

use Dipnet\Http\Requests\Document\UpdateDocumentRequest;
use Dipnet\Order;
use Dipnet\Delivery;
use Dipnet\Document;
use Illuminate\Http\UploadedFile;
use Dipnet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Dipnet\Http\Requests\DocumentRequest;
use Dipnet\Http\Requests\Document\StoreDocumentRequest;

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
        $documents = Document::orderBy('file_name')
            ->get()
            ->toJson();

        return view('documents.index', compact('documents'));
    }


    /**
     * Store a new document file.
     *
     * @param Order $order
     * @param Delivery $delivery
     * @param StoreDocumentRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Order $order, Delivery $delivery, StoreDocumentRequest $request)
    {
        $uploadedFile = $request->file('file');

        $document = $this->storeDocument($order, $delivery, $uploadedFile);

        Storage::disk('local')->putFileAs(
            'orders/' . $order->reference . '/' . $delivery->reference,
            $uploadedFile,
            $document->filename
        );

        return response($document, 200);
    }

    public function update(Order $order, Delivery $delivery, Document $document, UpdateDocumentRequest $request)
    {
        $document->article_id = $request->article_id;
        $document->finish = $request->finish;
        $document->quantity = $request->quantity;
        $document->articles()->sync($request->options);
        $document->save();

        return response(200);
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
        $this->authorize('delete', $document);

        $document->delete();

        return response(null, 204);
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
}