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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Order $order)
    {
        $order->load('business', 'contact', 'user', 'deliveries.contact', 'deliveries.documents.article', 'deliveries.documents.articles');

        return view('orders.complete.show', [
            'order' => $order
        ]);
    }

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
