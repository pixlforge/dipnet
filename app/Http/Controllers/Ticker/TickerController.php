<?php

namespace App\Http\Controllers\Ticker;

use App\Ticker;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticker\StoreTickerRequest;
use App\Http\Requests\Ticker\UpdateTickerRequest;

class TickerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $tickers = Ticker::all();

        return view('tickers.index', compact('tickers'));
    }

    public function store(StoreTickerRequest $request)
    {
        $ticker = new Ticker;
        $ticker->body = $request->body;
        $ticker->active = $request->active;
        $ticker->save();

        return response($ticker, 200);
    }

    public function update(UpdateTickerRequest $request, Ticker $ticker)
    {
        $ticker->body = $request->body;
        $ticker->active = $request->active;
        $ticker->save();

        return response($ticker, 200);
    }

    public function destroy(Ticker $ticker)
    {
        $ticker->delete();

        return response(null, 201);
    }
}
