<?php

namespace App\Http\Controllers\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;

class DeliveryReceiptController extends Controller
{
    /**
     * DeliveryReceiptController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Delivery $delivery)
    {
        $order = $delivery->order;
        $order->load('contact', 'managedBy');

        $company = $order->business->company;

        $user = $order->user;

        $delivery->load('contact');

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
