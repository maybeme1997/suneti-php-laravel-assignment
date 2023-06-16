<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        return view('publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new publisher.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('publishers.create');
    }

    /**
     * Store a newly created publisher in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Publisher::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);

        return redirect()->route('publishers.index');
    }

    /**
     * Show the form for editing the specified publisher.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\View\View
     */
    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified publisher in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $publisher->update([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);

        return redirect()->route('publishers.index');
    }
}
