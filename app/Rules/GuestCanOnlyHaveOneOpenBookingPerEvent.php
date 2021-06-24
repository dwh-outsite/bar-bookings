<?php

namespace App\Rules;

use App\Event;
use Illuminate\Contracts\Validation\Rule;

class GuestCanOnlyHaveOneOpenBookingPerEvent implements Rule
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
        return !$this->event->bookings()->where('email', $value)->active()->endDateInTheFuture()->exists();
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
