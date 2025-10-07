<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Hall;
use App\Models\HallAvailability;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin: tampilkan semua reservasi
            $reservations = Reservation::with(['user', 'hall'])
                ->latest()
                ->paginate(10);

            return view('reservations.index', compact('reservations'));
        } else {
            // User biasa: tampilkan hanya reservasi miliknya
            $reservations = Reservation::with(['user', 'hall'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);

            return view('reservations.index', compact('reservations'));
        }
    }



    public function create()
    {
        $users = User::all();
        $halls = Hall::all();
        $services = Service::all();

        return view('reservations.create', compact('users', 'halls', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'nullable|exists:users,id',
            'renter_name'  => 'nullable|string|max:255',
            'hall_id'      => 'required|exists:halls,id',
            'event_start'  => 'required|date',
            'event_end'    => 'required|date|after:event_start',
            'total_price'  => 'required|numeric',
            'status'       => 'required|in:pending,confirmed,cancelled',
            'services'     => 'nullable|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            // Cek apakah hall tersedia
            $existing = HallAvailability::where('hall_id', $request->hall_id)
                ->whereBetween('date', [$request->event_start, $request->event_end])
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->withInput()
                    ->with([
                        'message' => 'Gedung tidak tersedia pada tanggal ' . \Carbon\Carbon::parse($existing->date)->format('d M Y'),
                        'alert-type' => 'error'
                    ]);
            }

            // Simpan reservasi
            $reservation = Reservation::create([
                'renter_name'     => $request->renter_name ?: Auth::user()->name,
                'user_id'         => $request->user_id,
                'hall_id'         => $request->hall_id,
                'reservation_date'=> now(),
                'event_start'     => $request->event_start,
                'event_end'       => $request->event_end,
                'total_price'     => $request->total_price,
                'status'          => $request->status,
            ]);


            if ($request->has('services')) {
                foreach ($request->services as $srv) {
                    $service = Service::find($srv['service_id']);
                    if ($service) {
                        ReservationService::create([
                            'reservation_id' => $reservation->id,
                            'service_id'     => $service->id,
                            'quantity'       => $srv['quantity'],
                            'total_price'    => $service->price * $srv['quantity'],
                        ]);
                    }
                }
            }

        

            return redirect()->route('reservations.index')
                             ->with([
                                'message' => 'Reservasi berhasil dibuat, Mohon tunggu Admin melakukan konfirmasi.',
                                'alert-type' => 'success'
                             ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
            public function konfirmasi($id)
        {
            try {
                $reservation = Reservation::findOrFail($id);

                // Update status reservasi
                $reservation->status = 'confirmed';
                $reservation->save();

                Payment::create([
                    'reservation_id' => $reservation->id,
                    'amount' => $reservation->total_price,
                    'status' => 'unpaid',
                ]);

                return redirect()->route('reservations.index')
                                ->with([
                                    'message' => 'Reservasi berhasil dikonfirmasi dan Pembayaran dapat dilakukan.',
                                    'alert-type' => 'success'
                                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
            }
        }


    public function edit($id)
    {
        $reservation = Reservation::with('services')->findOrFail($id);
        $users = User::all();
        $halls = Hall::all();
        $services = Service::all();

        return view('reservations.edit', compact('reservation', 'users', 'halls', 'services'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        try {
            $reservation->update($request->all());

            return redirect()->route('reservations.index')->with([
                'message' => 'Reservasi berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return redirect()->route('reservations.index')->with([
                'message' => 'Reservasi berhasil dihapus.',
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
