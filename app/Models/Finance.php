<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'type',
        'description',
        'amount',
        'date',
        'reservation_id',
   
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
