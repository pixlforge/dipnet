<?php

namespace Dipnet\Http\Controllers\Order;

use Dipnet\Order;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;

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
     * Update the order's status.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Order $order)
    {
        $order->status = 'réceptionnée';
        $order->save();

        return response(200);
    }
}
