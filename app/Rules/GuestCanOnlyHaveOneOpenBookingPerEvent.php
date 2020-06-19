<?php

namespace App\Rules;

use App\Booking;
use App\Event;
use Illuminate\Contracts\Validation\Rule;

class GuestCanOnlyHaveOneOpenBookingPerEvent implements Rule
{
    private $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
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
        return !Booking::where('event_id', $this->eventId)->where('email', $value)->active()->endDateInTheFuture()->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A guest can only have one open booking.';
    }
}
