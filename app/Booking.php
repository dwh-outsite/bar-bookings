<?php

namespace App;

use App\Mail\BookingCanceled;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\EventMustHaveTwoseatCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBookingPerEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class Booking extends Model
{
    protected $guarded = [];
    protected $with = ['event'];
    protected $casts = [
        'twoseat' => 'boolean',
        'custom_fields' => 'array',
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

    public static function rules($eventId, $emailRequired = true)
    {
        $event = Event::find($eventId);

        if ($event == null) {
            throw ValidationException::withMessages([
                'event_id' => ['This event does not exist'],
            ]);
        }

        return array_merge([
            'name' => ['required', 'string', 'max:255'],
            'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft],
            'email' => $emailRequired ? ['required', 'email', 'max:255', new GuestCanOnlyHaveOneOpenBookingPerEvent($eventId)] : [],
            'twoseat' => ['boolean', new EventMustHaveTwoseatCapacityLeft($eventId)],
        ], $event->eventType->customFieldsValidationRules('custom_fields'));
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

    public function markAsPresent()
    {
        $this->update(['present' => Carbon::now()]);
    }

    public function unmarkAsPresent()
    {
        $this->update(['present' => null]);
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
