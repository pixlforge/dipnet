<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Http\Controllers\Controller;

class OrderReceiptController extends Controller
{
    /**
     * OrderReceiptController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show an existing order's receipt.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order = Order::with(
            'deliveries.contact',
            'deliveries.documents.articles',
            'deliveries.documents.article',
            'deliveries.documents.media'
        )->find($order->id);
        $company = $order->business->company;
        $user = $order->user;

        return view('orders.receipts.show', compact('order', 'company', 'user'));
    }
}
