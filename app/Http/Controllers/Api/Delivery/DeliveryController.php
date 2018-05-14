<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveriesCollection;

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
