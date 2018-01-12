<?php

namespace Dipnet\Http\Controllers\Document;

use Dipnet\Order;
use Dipnet\Delivery;
use Dipnet\Document;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;

class DocumentOptionController extends Controller
{
    /**
     * Clone a document's options to every document in a given delivery.
     *
     * @param Order $order
     * @param Delivery $delivery
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Order $order, Delivery $delivery, Request $request)
    {
        $documents = Document::where('delivery_id', $delivery->id)->get();

        foreach ($documents as $document) {
            $document->article_id = $request->print;
            $document->finish = $request->finish;
            $document->quantity = $request->quantity;
            $document->width = $request->width;
            $document->height = $request->height;
            $document->save();

            $document->articles()->sync($request->options);
        }

        return response(200);
    }
}
