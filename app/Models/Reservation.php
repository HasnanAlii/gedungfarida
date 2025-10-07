<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'hall_id',
        'reservation_date',
        'event_start',
        'event_end',
        'total_price',
        'status',
        'renter_name'
    ];
        protected $casts = [
        'reservation_date' => 'date',
        'event_start'      => 'date',
        'event_end'        => 'date',
    ];


  
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'reservation_services')
                    ->withPivot('quantity', 'total_price')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }
}
