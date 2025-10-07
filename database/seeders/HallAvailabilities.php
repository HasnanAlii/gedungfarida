<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall;
use App\Models\HallAvailability;
use Carbon\Carbon;

class HallAvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $hall = Hall::first();

        // Gedung unavailable selama 3 hari (misalnya ada perbaikan)
        for ($i = 1; $i <= 3; $i++) {
            HallAvailability::create([
                'hall_id' => $hall->id,
                'date' => Carbon::now()->addDays($i),
                'status' => 'unavailable',
                'note' => 'Maintenance',
            ]);
        }

        // Tambahkan tanggal tersedia
        HallAvailability::create([
            'hall_id' => $hall->id,
            'date' => Carbon::now()->addDays(5),
            'status' => 'available',
            'note' => 'Available for booking',
        ]);
    }
}
