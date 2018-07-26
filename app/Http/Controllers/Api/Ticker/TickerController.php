<?php

namespace App\Http\Controllers\Api\Ticker;

use App\Ticker;
use App\Http\Controllers\Controller;
use App\Http\Resources\TickersCollection;

class TickerController extends Controller
{
    public function index($sort = 'active')
    {
        return new TickersCollection(
            Ticker::orderBy($sort, 'desc')->latest()->paginate(25)
        );
    }
}
