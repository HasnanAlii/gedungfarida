<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        try {
            Hall::create($request->all());

            return redirect()->route('halls.index')
                ->withInput()
                ->with([
                    'message' => 'Gedung berhasil ditambahkan pada ' . Carbon::now()->format('d M Y H:i'),
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Terjadi kesalahan saat menambah gedung: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
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

        try {
            $hall->update($request->all());

            return redirect()->route('halls.index')
                ->withInput()
                ->with([
                    'message' => 'Gedung berhasil diperbarui ' ,
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Gagal memperbarui gedung: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Remove the specified hall from storage.
     */
    public function destroy(Hall $hall)
    {
        try {
            $hall->delete();

            return redirect()->route('halls.index')
                ->with([
                    'message' => 'Gedung berhasil dihapus pada ' . Carbon::now()->format('d M Y H:i'),
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with([
                    'message' => 'Gagal menghapus gedung: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }
}
