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

    public function show(Order $order)
    {
        return view('orders.receipts.show', [
            'order' => $order
        ]);
    }
}
