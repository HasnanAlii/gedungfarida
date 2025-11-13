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
                'name' => 'Gedung Farida',
                'description' => 'Gedung untuk 150 tamu.',
                'capacity' => 150,
                'price' => 5300000,
            ],
        ]);
    }
}
