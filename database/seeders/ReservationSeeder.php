<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\User;
use App\Models\Hall;
use App\Models\Service;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // ambil user pertama
        $hall = Hall::first();

        $reservation = Reservation::create([
            'user_id' => $user->id, // ganti dari customer_id ke user_id
            'hall_id' => $hall->id,
            'reservation_date' => Carbon::now()->addDays(10),
            'event_start' => Carbon::now()->addDays(30)->setTime(10, 0),
            'event_end' => Carbon::now()->addDays(30)->setTime(22, 0),
            'total_price' => 55000000,
            'status' => 'confirmed',
        ]);

        $service = Service::first();
        ReservationService::create([
            'reservation_id' => $reservation->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'total_price' => $service->price,
        ]);
    }
}
