<?php

namespace App;

use App\Mail\BookingCanceled;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class Booking extends Model
{
    protected $guarded = [];
    protected $with = ['event'];
    protected $casts = [
        'twoseat' => 'boolean',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->cancelation_token = static::generateCancelationToken();
        });
    }

    public static function generateCancelationToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(24));
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeEndDateInTheFuture(Builder $query)
    {
        $query->whereHas('event', function (Builder $eventQuery) {
            $eventQuery->endDateInTheFuture();
        });
    }

    public function scopeActive(Builder $query)
    {
        $query->where('status', 'active');
    }

    public function scopeTwoseat(Builder $query)
    {
        $query->where('twoseat', true);
    }

    public function cancel()
    {
        $this->update(['status' => 'canceled']);

        Mail::to($this->email)->queue(new BookingCanceled($this));
    }

    public function cancelationUrl()
    {
        return route('api.bookings.cancel', ['token' => $this->cancelation_token]);
    }

    public function isCanceled()
    {
        return $this->status == 'canceled';
    }

    public function isActive()
    {
        return $this->status == 'active';
    }
}
