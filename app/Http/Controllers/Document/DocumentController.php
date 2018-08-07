<?php

namespace App\Http\Controllers\Document;

use App\Delivery;
use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.email.confirmed'
        ]);
    }

    /**
     * @param StoreDocumentRequest $request
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreDocumentRequest $request, Delivery $delivery)
    {
        $this->authorize('touch', $delivery);

        $document = new Document;
        $document->delivery()->associate($delivery);
        $document->save();

        $document->addMedia($request->file)->toMediaCollection('documents');

        return response($document, 200);
    }

    /**
     * @param UpdateDocumentRequest $request
     * @param Document $document
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $this->authorize('touch', $document);

        $document->article_id = $request->article_id;
        $document->finish = $request->finish;
        $document->quantity = $request->quantity;
        $document->width = $request->width;
        $document->height = $request->height;
        $document->nb_orig = $request->nb_orig;
        $document->articles()->sync($request->options);
        $document->save();

        return response($document, 200);
    }

    /**
     * @param Document $document
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Document $document)
    {
        $this->authorize('touch', $document);
        
        abort_if($document->delivery->order->status !== 'incomplète', 403, "Vous n'êtes pas autorisé à faire cela.");

        if ($document->hasMedia()) {
            $media = $document->getMedia();
            $media->delete();
        }

        $document->delete();

        return response(null, 204);
    }
}
