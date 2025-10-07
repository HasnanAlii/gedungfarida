<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finance;
use App\Models\Reservation;
use Carbon\Carbon;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $reservation = Reservation::first();

        Finance::create([
            'type' => 'income',
            'description' => 'Pembayaran DP untuk reservasi gedung',
            'amount' => 20000000,
            'date' => Carbon::now(),
            'reservation_id' => $reservation->id,
        ]);

        Finance::create([
            'type' => 'expense',
            'description' => 'Biaya listrik dan kebersihan bulanan',
            'amount' => 5000000,
            'date' => Carbon::now(),
            'reservation_id' => null,
        ]);
    }
}
