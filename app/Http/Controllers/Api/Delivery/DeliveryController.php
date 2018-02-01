<?php

namespace Dipnet\Http\Controllers\Api\Delivery;

use Dipnet\Delivery;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\DeliveriesCollection;

class DeliveryController extends Controller
{
    /**
     * DeliveryController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return DeliveriesCollection
     */
    public function index()
    {
        return new DeliveriesCollection(Delivery::latest()->with(['order', 'contact'])->paginate(25));
    }
}
