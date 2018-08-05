<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveriesCollection;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($sort = 'created_at')
    {
        if ($sort === 'created_at') {
            if (auth()->user()->isAdmin()) {
                return new DeliveriesCollection(
                    Delivery::latest()->with('order', 'contact')->paginate(25)
                );
            } elseif (auth()->user()->isPartOfACompany()) {
                return new DeliveriesCollection(
                    Delivery::ownedByUsersCompany()->latest()->with('order', 'contact')->paginate(25)
                );
            } elseif (auth()->user()->isSolo()) {
                return new DeliveriesCollection(
                    Delivery::ownedBySoloUser()->latest()->with('order', 'contact')->paginate(25)
                );
            }
        } else {
            if (auth()->user()->isAdmin()) {
                return new DeliveriesCollection(
                    Delivery::orderBy($sort)->with('order', 'contact')->paginate(25)
                );
            } elseif (auth()->user()->isPartOfACompany()) {
                return new DeliveriesCollection(
                    Delivery::ownedByUsersCompany()->orderBy($sort)->with('order', 'contact')->paginate(25)
                );
            } elseif (auth()->user()->isSolo()) {
                return new DeliveriesCollection(
                    Delivery::ownedBySoloUser()->orderBy($sort)->with('order', 'contact')->paginate(25)
                );
            }
        }
    }
}
