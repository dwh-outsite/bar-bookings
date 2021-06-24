<?php

namespace App\Rules;

use App\Booking;
use App\Event;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class GuestCanOnlyHaveOneOpenBookingPerEventType implements Rule
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->event->eventType->single_booking) {
            return true;
        }

        return !Booking::where('email', $value)
            ->active()
            ->whereHas('event', function (Builder $eventQuery) {
                $eventQuery->where('event_type_id', $this->event->event_type_id)
                    ->where('id', '!=', $this->event->id);
            })
            ->endDateInTheFuture()
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A guest can only have one open booking per event type.';
    }
}
