<?php

namespace Dipnet\Http\Controllers\Order;

use Dipnet\Http\Controllers\Controller;
use Dipnet\Mail\AdminOrderCompleteNotification;
use Dipnet\Mail\CustomerOrderCompleteConfirmation;
use Dipnet\Order;
use Illuminate\Support\Facades\Mail;

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
