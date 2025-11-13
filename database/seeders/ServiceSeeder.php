<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::insert([
            ['name' => 'Catering 1 pax', 'price' => 50000],
        ]);
    }
}
