<?php

namespace App\Http\Controllers\Order;

use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\AdminOrderCompleteNotification;
use App\Mail\CustomerOrderCompleteConfirmation;
use App\Http\Requests\Order\CompleteOrderRequest;

class CompleteOrderController extends Controller
{
    /**
     * CompleteOrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a completed order's details.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order = Order::with(
            'business',
            'contact',
            'deliveries.contact',
            'deliveries.documents.article',
            'deliveries.documents.articles',
            'deliveries.documents.media'
        )->find($order->id);
        
        return view('orders.complete.show', compact('order'));
    }

    /**
     * Update an existing order's status.
     *
     * @param CompleteOrderRequest $request
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(CompleteOrderRequest $request, Order $order)
    {
        $order->status = 'envoyée';
        $order->save();

        Mail::to(auth()->user()->email)
            ->queue(new CustomerOrderCompleteConfirmation($order));

        Mail::to('admin@dipnet.ch')
            ->queue(new AdminOrderCompleteNotification($order));

        return response(null, 200);
    }
}
