<?php

namespace Dipnet\Http\Controllers\Order;

use Dipnet\Delivery;
use Dipnet\Document;
use Dipnet\Order;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;

class OrderValidationController extends Controller
{
    /**
     * OrderValidationController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function validation(Order $order, Request $request)
    {
        if ($order->deliveries->count() < 1) {
            abort(422, "Au moins une livraison est requise pour passer commande.");
        }

        if ($order->status !== 'incomplète') {
            abort(422, "La commande doit être incomplète pour être complétée.");
        }

        if ($order->business_id === null) {
            abort(422, "La commande doit être associée à une affaire existante.");
        }

        if ($order->contact_id === null) {
            abort(422, "La commande doit être associée à un contact de facturation.");
        }

        $deliveries = Delivery::where('order_id', $order->id)->get();

        foreach ($deliveries as $delivery) {
            if ($delivery->contact_id === null) {
                abort(422, "Une livraison ne contient pas de contact de livraison.");
            }

            if ($delivery->to_deliver_at === null) {
                abort(422, "Une livraison ne contient pas de date de livraison.");
            }
        }

        $documents = Document::whereIn('delivery_id', array_values($deliveries->pluck('id')->toArray()))->get();

        foreach ($documents as $document) {
            if ($document->article_id === null) {
                abort(422, "Un document ne contient pas de type d'impression spécifié.");
            }

            if ($document->articles->count() < 1) {
                abort(422, "Un document ne contient aucune option d'impression.");
            }
        }

        return response(200);
    }
}
