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
        'ggd_consent' => 'boolean',
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

    public static function rules($eventId, $emailRequired = true, $customFieldsRequired = true)
    {
        $event = Event::find($eventId);

        if ($event == null) {
            throw ValidationException::withMessages([
                'event_id' => ['This event does not exist'],
            ]);
        }

        return array_merge(
            [
                'name' => ['required', 'string', 'max:255'],
                'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft],
                'email' => array_merge(
                    $emailRequired ? ['required', new GuestCanOnlyHaveOneOpenBookingPerEvent($eventId)] : ['required_if:ggd_consent,true'],
                    ['email', 'max:255']
                ),
                'ggd_consent' => ['nullable', 'boolean'],
                'phone_number' => ['nullable', 'string', 'required_if:ggd_consent,true'],
                'twoseat' => ['boolean', new EventMustHaveTwoseatCapacityLeft($eventId)],
            ],
            $customFieldsRequired ? $event->eventType->customFieldsValidationRules('custom_fields') : []
        );
    }

    public static function generateCancelationToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(24));
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tablePlacements()
    {
        return $this->hasMany(TablePlacement::class);
    }

    public function currentTablePlacement()
    {
        return $this->tablePlacements->last();
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
        if (is_null($this->present)) {
            $this->update(['present' => Carbon::now()]);
        }
    }

    public function markAsLeft()
    {
        $this->update([
            'status' => 'left',
            'left' => Carbon::now()
        ]);
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

    public function isPresent()
    {
        return !is_null($this->present);
    }

    public function hasLeft()
    {
        return !is_null($this->left);
    }
}
