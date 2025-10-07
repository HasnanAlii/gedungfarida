<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'price',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function availabilities()
    {
        return $this->hasMany(HallAvailability::class);
    }

}
