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

    /**
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Delivery $delivery)
    {
        $order = $delivery->order;
        $order = $order->load('contact');

        $company = $order->business->company;

        $user = $order->user;

        $delivery = $delivery->load('contact');

        $documents = $delivery->documents;
        $documents = $documents->load(['article', 'articles']);

        return view('deliveries.receipts.show', [
            'order' => $order,
            'delivery' => $delivery,
            'documents' => $documents,
            'company' => $company,
            'user' => $user
        ]);
    }
}
