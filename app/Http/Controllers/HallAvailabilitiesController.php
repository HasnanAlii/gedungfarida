<?php

namespace App\Http\Controllers;

use App\Models\HallAvailability;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallAvailabilitiesController extends Controller
{
    /**
     * Menampilkan daftar ketersediaan gedung (tampilan kalender)
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
     * Form untuk menambahkan ketersediaan gedung baru
     */
    public function create()
    {
        $halls = Hall::all();
        return view('calendar.create', compact('halls'));
    }

    /**
     * Simpan data ketersediaan gedung baru
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
                'message' => 'Data ketersediaan gedung berhasil disimpan.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Form untuk mengedit data ketersediaan gedung
     */
    public function edit(HallAvailability $calendar)
    {
        $halls = Hall::all();
        return view('calendar.edit', compact('calendar', 'halls'));
    }

    /**
     * Perbarui data ketersediaan gedung
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
                'message' => 'Data ketersediaan gedung berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Hapus data ketersediaan gedung
     */
    public function destroy(HallAvailability $calendar)
    {
        try {
            $calendar->delete();

            return redirect()->route('calendar.index')->with([
                'message' => 'Data ketersediaan gedung berhasil dihapus.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
