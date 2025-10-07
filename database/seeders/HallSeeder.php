<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        Hall::insert([
            [
                'name' => 'Grand Ballroom',
                'description' => 'Gedung besar untuk 1000 tamu.',
                'capacity' => 1000,
                'price' => 50000000,
            ],
            [
                'name' => 'VIP Hall',
                'description' => 'Hall eksklusif untuk 300 tamu.',
                'capacity' => 300,
                'price' => 20000000,
            ],
            [
                'name' => 'Outdoor Garden',
                'description' => 'Area taman terbuka untuk 500 tamu.',
                'capacity' => 500,
                'price' => 30000000,
            ],
        ]);
    }
}
