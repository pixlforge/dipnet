<?php

namespace App\Http\Controllers\Order;

use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\AdminOrderCompleteNotification;
use App\Mail\CustomerOrderCompleteConfirmation;

class CompleteOrderController extends Controller
{
    /**
     * CompleteOrderController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a completed order to the user.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load('business', 'contact', 'user', 'deliveries.contact', 'deliveries.documents.article', 'deliveries.documents.articles');

        return view('orders.complete.show', [
            'order' => $order
        ]);
    }

    /**
     * Update the status of the order.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Order $order)
    {
        $order->status = 'envoyée';
        $order->save();

        Mail::to(auth()->user())
            ->queue(new CustomerOrderCompleteConfirmation($order));

        Mail::to('admin@example.com')
            ->queue(new AdminOrderCompleteNotification($order));

        return response(200);
    }
}
