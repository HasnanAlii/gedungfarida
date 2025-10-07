<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_services')
                    ->withPivot('quantity', 'total_price')
                    ->withTimestamps();
    }
}
