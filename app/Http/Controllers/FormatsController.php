<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Format;

class FormatsController extends Controller
{
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:formats|min:2|max:45',
            'height' => 'required',
            'width' => 'required',
        ]);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
