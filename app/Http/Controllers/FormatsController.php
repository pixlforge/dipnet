<?php

namespace App\Http\Controllers;

use App\Format;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\FormatRequest;

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
        $this->authorize('view', Format::class);

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
        $this->authorize('create', Format::class);

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
        $this->authorize('create', Format::class);

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
        $this->authorize('view', $format);

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
        $this->authorize('update', $format);

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
        $this->authorize('update', $format);

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
        $this->authorize('delete', $format);

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
        $this->authorize('restore', Format::class);

        Format::onlyTrashed()->where('id', $format)->restore();

        return redirect()->route('formats');
    }
}
