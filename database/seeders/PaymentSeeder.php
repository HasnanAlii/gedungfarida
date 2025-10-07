<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $reservation = Reservation::first();

        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => 20000000,
            'method' => 'transfer',
            'payment_date' => Carbon::now(),
            'status' => 'paid',
        ]);
    }
}
