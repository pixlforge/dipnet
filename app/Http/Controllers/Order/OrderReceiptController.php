<?php

namespace Dipnet\Http\Controllers\Order;

use Dipnet\Http\Controllers\Controller;
use Dipnet\Order;

class OrderReceiptController extends Controller
{
    /**
     * OrderReceiptController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $company = $order->business->company;
        $user = $order->user;

        return view('orders.receipts.show', [
            'order' => $order,
            'company' => $company,
            'user' => $user
        ]);
    }
}
