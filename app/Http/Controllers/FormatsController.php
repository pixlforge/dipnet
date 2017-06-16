<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatRequest;
use Illuminate\Http\Request;
use App\Format;

class FormatsController extends Controller
{
    /**
     * FormatsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formats = Format::withTrashed()->get();
        return view('formats.index', compact('formats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormatRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormatRequest $request)
    {
        Format::create([
            'name' => request('name'),
            'height' => request('height'),
            'width' => request('width'),
            'surface' => request('surface'),
        ]);

        return redirect()->route('formats');
    }

    /**
     * Display the specified resource.
     *
     * @param Format $format
     * @return \Illuminate\Http\Response
     */
    public function show(Format $format)
    {
        return view('formats.show', compact('format'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Format $format
     * @return \Illuminate\Http\Response
     */
    public function edit(Format $format)
    {
        return view('formats.edit', compact('format'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormatRequest $request
     * @param Format $format
     * @return \Illuminate\Http\Response
     */
    public function update(FormatRequest $request, Format $format)
    {
        $format->update([
            'name' => request('name'),
            'height' => request('height'),
            'width' => request('width'),
            'surface' => request('surface')
        ]);

        return redirect()->route('formats');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Format $format
     * @return \Illuminate\Http\Response
     */
    public function destroy(Format $format)
    {
        $format->delete();
        return redirect()->route('formats');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $format
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($format)
    {
        Format::onlyTrashed()->where('name', $format)->restore();
        return redirect()->route('formats');
    }
}
