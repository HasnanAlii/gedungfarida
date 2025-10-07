<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::insert([
            ['name' => 'Catering 500 pax', 'price' => 15000000],
            ['name' => 'Dekorasi Premium', 'price' => 8000000],
            ['name' => 'Sound System & Band', 'price' => 5000000],
            ['name' => 'Photographer & Videographer', 'price' => 6000000],
        ]);
    }
}
