<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Hall;
use App\Models\HallAvailability;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ReservationService;
use Carbon\Carbon;
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
    public function show($id)
    {
        $user = Auth::user();
        
        // Muat semua relasi yang mungkin
        $reservation = Reservation::with(['user', 'hall', 'services', 'payments'])
            ->findOrFail($id);

        // Otorisasi: Admin boleh lihat semua, customer hanya boleh lihat miliknya
        if (!$user->hasRole('admin') && $reservation->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        return view('reservations.show', compact('reservation'));
    }
    public function cleanupOldData()
    {
        $threshold = Carbon::now()->subMonths(2);

        // Hitung total sebelum dihapus
        $oldReservations = Reservation::where('event_end', '<', $threshold)->count();
        $oldPayments = Payment::where('payment_date', '<', $threshold)->count();
        $oldHalls = HallAvailability::where('date_end', '<', $threshold)->count();

        // Hapus data lama
        Reservation::where('event_end', '<', $threshold)->delete();
        Payment::where('payment_date', '<', $threshold)->delete();
        HallAvailability::where('date_end', '<', $threshold)->delete();

        // Kirim pesan ke session
        return redirect()->back()->with([
        'message' => 'Data Lebih Dari 2 bulan lalu berhasil dihapus.',
        'alert-type' => 'success'
    ]);
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
    // Ubah format tanggal dari d-m-Y → Y-m-d agar bisa dibandingkan di database
    $eventStart = \Carbon\Carbon::createFromFormat('d-m-Y', $request->event_start)->format('Y-m-d');
    $eventEnd   = \Carbon\Carbon::createFromFormat('d-m-Y', $request->event_end)->format('Y-m-d');

    // Cek apakah hall sedang digunakan
    $existing = HallAvailability::where('hall_id', $request->hall_id)
        ->where('status', 'unavailable')
        ->where(function ($query) use ($eventStart, $eventEnd) {
            $query->whereBetween('date', [$eventStart, $eventEnd])
                ->orWhereBetween('date_end', [$eventStart, $eventEnd])
                ->orWhere(function ($query) use ($eventStart, $eventEnd) {
                    $query->where('date', '<=', $eventStart)
                          ->where('date_end', '>=', $eventEnd);
                });
        })
        ->first();

    if ($existing) {
        return redirect()->back()
            ->withInput()
            ->with([
                'message' => 'Gedung tidak tersedia pada rentang ' .
                    \Carbon\Carbon::parse($existing->date)->format('d M Y') .
                    ' - ' .
                    \Carbon\Carbon::parse($existing->date_end)->format('d M Y'),
                'alert-type' => 'error'
            ]);
    }

    // Lanjut simpan data reservasi jika tersedia
    $reservation = Reservation::create([
        'renter_name'      => $request->renter_name ?: Auth::user()->name,
        'user_id'          => $request->user_id,
        'hall_id'          => $request->hall_id,
        'reservation_date' => now(),
        'event_start'      => $eventStart,
        'event_end'        => $eventEnd,
        'total_price'      => $request->total_price,
        'status'           => $request->status,
    ]);



    return redirect()->route('reservations.index')->with([
        'message' => 'Reservasi berhasil dibuat. Mohon tunggu Admin melakukan konfirmasi.',
        'alert-type' => 'success'
    ]);

} catch (\Exception $e) {
    return redirect()->back()
        ->withInput()
        ->with([
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
