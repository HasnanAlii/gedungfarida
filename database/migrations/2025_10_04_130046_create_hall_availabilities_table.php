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
            $table->foreignId('reservation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date'); 
            $table->date('date_end' ); 
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('note')->nullable(); 
            $table->timestamps();

            $table->unique(['hall_id', 'date']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hall_availabilities');
    }
}
