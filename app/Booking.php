<?php

namespace App;

use App\Mail\BookingCanceled;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\EventMustHaveTwoseatCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBookingPerEvent;
use App\Rules\GuestCanOnlyHaveOneOpenBookingPerEventType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public static function rules($event)
    {
        return array_merge(
            [
                'name' => ['required', 'string', 'max:255'],
                'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft($event)],
                'email' => ['required',  'email', 'max:255', new GuestCanOnlyHaveOneOpenBookingPerEvent($event), new GuestCanOnlyHaveOneOpenBookingPerEventType($event)],
                'ggd_consent' => ['nullable', 'boolean'],
                'phone_number' => ['nullable', 'string', 'required_if:ggd_consent,true'],
                'twoseat' => ['boolean', new EventMustHaveTwoseatCapacityLeft($event)],
            ],
            $event->eventType->customFieldsValidationRules('custom_fields')
        );
    }

    public static function barRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'event_id' => ['required', 'integer'],
            'twoseat' => ['boolean'],
        ];
    }

    public static function visitorRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'ggd_consent' => ['nullable', 'boolean'],
            'email' => ['nullable', 'required_if:ggd_consent,true', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'required_if:ggd_consent,true'],
        ];
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

    public function scopePresent(Builder $query)
    {
        $query->where('status', 'active')
            ->whereNotNull('present');
    }

    public function scopeLeft(Builder $query)
    {
        $query->where('status', 'left');
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

    public function getVisitorCodeAttribute($visitorCode)
    {
        if (is_null($visitorCode)) {
            $visitorCode = strtoupper(Str::random(6));
            $this->update(['visitor_code' => $visitorCode]);
            $this->refresh();
        }

        return $visitorCode;
    }
}
