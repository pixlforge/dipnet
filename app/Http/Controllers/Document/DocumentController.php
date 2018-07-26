<?php

namespace App\Http\Controllers\Document;

use App\Order;
use App\Delivery;
use App\Document;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.email.confirmed'
        ]);
    }

    public function index()
    {
        $documents = Document::orderBy('filename')
            ->with('article')
            ->get()
            ->toJson();

        return view('documents.index', compact('documents'));
    }

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

    public function update(UpdateDocumentRequest $request, Order $order, Delivery $delivery, Document $document)
    {
        $document->article_id = $request->article_id;
        $document->finish = $request->finish;
        $document->quantity = $request->quantity;
        $document->articles()->sync($request->options);
        $document->width = $request->width;
        $document->height = $request->height;
        $document->nb_orig = $request->nb_orig;
        $document->save();

        return response(200);
    }

    public function destroy(Order $order, Delivery $delivery, Document $document)
    {
        $document->delete();

        return response(null, 204);
    }

    protected function storeDocument(Order $order, Delivery $delivery, UploadedFile $uploadedFile)
    {
        $document = new Document;
        $document->filename = $uploadedFile->getClientOriginalName();
        $document->mime_type = $uploadedFile->getClientMimeType();
        $document->size = $uploadedFile->getSize();
        $document->finish = 'roulé';
        $document->delivery_id = $delivery->id;
        $document->delivery()->associate($delivery);
        $document->save();

        return $document;
    }
}
