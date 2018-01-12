<?php

namespace Dipnet\Http\Controllers\Delivery;

use Dipnet\Delivery;
use Dipnet\Http\Controllers\Controller;

class DeliveryReceiptController extends Controller
{
    /**
     * DeliveryReceiptController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function show(Delivery $delivery)
    {
        $order = $delivery->order;
        $order = $order->load('contact');

        $delivery = $delivery->load('contact');

        $documents = $delivery->documents;
        $documents = $documents->load(['article', 'articles']);

        return view('deliveries.receipts.show', [
            'order' => $order,
            'delivery' => $delivery,
            'documents' => $documents
        ]);
    }
}
