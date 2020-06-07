<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['start', 'end'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availableSeats()
    {
        return $this->capacity - $this->bookings()->active()->count();
    }

    public function availableTwoseats()
    {
        return $this->twoseat_capacity - $this->bookings()->twoseat()->active()->count();
    }

    public function scopeEndDateInTheFuture($query, $includedPastHours = 0)
    {
        $query->where('end', '>=', Carbon::now()->subHours($includedPastHours));
    }

    public function scopeEndDateInThePast($query)
    {
        $query->where('end', '<', Carbon::now());
    }
}
