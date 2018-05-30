<?php

namespace App\Http\Controllers\Api\Ticker;

use App\Http\Controllers\Controller;
use App\Http\Resources\TickersCollection;
use App\Ticker;

class TickerController extends Controller
{
    public function index()
    {
        return new TickersCollection(
            Ticker::orderBy('active', 'desc')->latest()->paginate(25)
        );
    }
}
