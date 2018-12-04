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
     * Show a delivery's receipt.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Delivery $delivery)
    {
        $delivery = Delivery::with(
            'order.company',
            'order.user',
            'documents.media',
            'documents.article',
            'documents.articles'
        )->find($delivery->id);

        $business = $delivery->order->business()->withTrashed()->first();

        return view('deliveries.receipts.show', compact('delivery', 'business'));
    }
}
