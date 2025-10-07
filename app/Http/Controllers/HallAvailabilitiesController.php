<?php

namespace App\Http\Controllers;

use App\Models\HallAvailability;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallAvailabilitiesController extends Controller
{
    /**
     * Display a listing of the resource (Calendar view).
     */
    public function index()
    {
        $dates = HallAvailability::with(['hall', 'reservation.services'])
                    ->orderBy('date', 'asc')
                    ->get();

        return view('calendar.index', compact('dates'));
    }
        public function indexx()
    {
        $dates = HallAvailability::with(['hall', 'reservation.services'])
                    ->orderBy('date', 'asc')
                    ->get();

        return view('calendar.indexx', compact('dates'));
    }

    /**
     * Show the form for creating a new hall availability.
     */
    public function create()
    {
        $halls = Hall::all();
        return view('calendar.create', compact('halls'));
    }

    /**
     * Store a newly created hall availability in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'date'    => 'required|date',
            'status'  => 'required|in:available,unavailable',
            'note'    => 'nullable|string|max:255',
        ]);

        try {
            HallAvailability::updateOrCreate(
                [
                    'hall_id' => $request->hall_id,
                    'date'    => $request->date
                ],
                [
                    'status' => $request->status,
                    'note'   => $request->note,
                ]
            );

            return redirect()->route('calendar.index')->with([
                'message' => 'Hall availability saved successfully.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show the form for editing the specified hall availability.
     */
    public function edit(HallAvailability $calendar)
    {
        $halls = Hall::all();
        return view('calendar.edit', compact('calendar', 'halls'));
    }

    /**
     * Update the specified hall availability in storage.
     */
    public function update(Request $request, HallAvailability $calendar)
    {
        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'date'    => 'required|date',
            'status'  => 'required|in:available,unavailable',
            'note'    => 'nullable|string|max:255',
        ]);

        try {
            $calendar->update($request->all());

            return redirect()->route('calendar.index')->with([
                'message' => 'Hall availability updated successfully.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified hall availability from storage.
     */
    public function destroy(HallAvailability $calendar)
    {
        try {
            $calendar->delete();

            return redirect()->route('calendar.index')->with([
                'message' => 'Hall availability deleted successfully.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
