<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallAvailability extends Model
{
    protected $fillable = [
        'hall_id',
        'date',
        'date_end',
        'status',
        'note',
        'reservation_id'
    ];
      protected $casts = [
        'date' => 'date', // <-- ini penting
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
 
    // app/Models/HallAvailability.php
    public function reservation()
    {
        return $this->belongsTo(Reservation::class); // menggunakan reservation_id
    }





public function user()
{
    return $this->belongsTo(User::class);
}

}
