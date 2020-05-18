<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
