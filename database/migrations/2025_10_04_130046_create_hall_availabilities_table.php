<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallAvailabilitiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('hall_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            
            // Tambah reservation_id (nullable, karena kadang hanya untuk maintenance atau available)
            $table->foreignId('reservation_id')->nullable()->constrained()->cascadeOnDelete();

            $table->date('date'); // tanggal tertentu
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('note')->nullable(); // alasan (misalnya "dipakai", "maintenance")
            $table->timestamps();

            $table->unique(['hall_id', 'date']); // satu hall hanya punya 1 status per hari
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hall_availabilities');
    }
}
