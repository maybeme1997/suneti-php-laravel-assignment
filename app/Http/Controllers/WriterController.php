<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function index()
    {
        $writers = Writer::all();
        return view('writers.index', compact('writers'));
    }

    /**
     * Show the form for creating a new writer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('writers.create');
    }

    /**
     * Store a newly created writer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        Writer::create([
            'name' => $request->input('name'),
            'bio' => $request->input('bio'),
        ]);

        return redirect()->route('writers.index');
    }

    /**
     * Show the form for editing the specified writer.
     *
     * @param  \App\Models\Writer  $writer
     * @return \Illuminate\View\View
     */
    public function edit(Writer $writer)
    {
        return view('writers.edit', compact('writer'));
    }

    /**
     * Update the specified writer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Writer  $writer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Writer $writer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $writer->update([
            'name' => $request->input('name'),
            'bio' => $request->input('bio'),
        ]);

        return redirect()->route('writers.index');
    }
}
