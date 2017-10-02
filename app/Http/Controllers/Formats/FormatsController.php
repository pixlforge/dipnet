<?php

namespace App\Http\Controllers\Formats;

use App\Format;
use App\Http\Requests\FormatRequest;
use App\Http\Controllers\Controller;

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
     * Display a listing of the Format models.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Format::class);

        $formats = Format::latest()
            ->orderBy('name')
            ->get()
            ->toJson();

        if (request()->wantsJson()) {
            return $formats;
        }

        return view('formats.index', compact('formats'));
    }

    /**
     * Save a new Format model.
     *
     * @param FormatRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormatRequest $request)
    {
        $this->authorize('create', Format::class);

        $format = Format::create([
            'name' => $request->name,
            'height' => $request->height,
            'width' => $request->width,
            'surface' => $request->surface,
        ]);

        if (request()->expectsJson()) {
            return $format->id;
        }

        return redirect()->route('formats.index');
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

        $format = $format->update([
            'name' => $request->name,
            'height' => $request->height,
            'width' => $request->width,
            'surface' => $request->surface
        ]);

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return redirect()->route('formats.index');
    }

    /**
     * Delete the Format model.
     *
     * @param Format $format
     * @return \Illuminate\Http\Response
     */
    public function destroy(Format $format)
    {
        $this->authorize('delete', $format);

        $format->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('formats.index');
    }
}