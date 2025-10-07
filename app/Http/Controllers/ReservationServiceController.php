<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Hall;
use App\Models\Service;
use App\Models\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'hall', 'services'])->paginate(10);
        return view('reservations.index', compact('reservations'));
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
            'user_id' => 'required|exists:users,id',
            'hall_id' => 'required|exists:halls,id',
            'reservation_date' => 'required|date',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'status' => 'required|string',
        ]);

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'hall_id' => $request->hall_id,
            'reservation_date' => $request->reservation_date,
            'event_start' => $request->event_start,
            'event_end' => $request->event_end,
            'total_price' => 0,
            'status' => $request->status,
        ]);

        if ($request->services) {
            foreach ($request->services as $service_id) {
                $service = Service::find($service_id);
                ReservationService::create([
                    'reservation_id' => $reservation->id,
                    'service_id' => $service->id,
                    'quantity' => 1,
                    'total_price' => $service->price,
                ]);

                $reservation->total_price += $service->price;
            }
            $reservation->save();
        }

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat ');
    }
}
