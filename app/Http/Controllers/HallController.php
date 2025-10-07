<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    /**
     * Display a listing of halls.
     */
    public function index()
    {
        $halls = Hall::paginate(10);
        return view('halls.index', compact('halls'));
    }

    /**
     * Show the form for creating a new hall.
     */
    public function create()
    {
        return view('halls.create');
    }

    /**
     * Store a newly created hall in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Hall::create($request->all());

        return redirect()->route('halls.index')->with('success', 'Gedung berhasil ditambah.');
    }

    /**
     * Show the form for editing the specified hall.
     */
    public function edit(Hall $hall)
    {
        return view('halls.edit', compact('hall'));
    }

    /**
     * Update the specified hall in storage.
     */
    public function update(Request $request, Hall $hall)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $hall->update($request->all());

        return redirect()->route('halls.index')->with('success', 'Gedung berhasil diperbarui.');
    }

    /**
     * Remove the specified hall from storage.
     */
    public function destroy(Hall $hall)
    {
        $hall->delete();

        return redirect()->route('halls.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
