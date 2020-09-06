<?php

namespace App\Rules;

use App\Event;
use Illuminate\Contracts\Validation\Rule;

class EventMustHaveTwoseatCapacityLeft implements Rule
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  boolean  $twoseatEnabled
     * @return bool
     */
    public function passes($attribute, $twoseatEnabled)
    {
        if (!$twoseatEnabled) {
            return true;
        }

        return $this->event->twoseat_capacity - $this->event->bookings()->twoseat()->active()->lockForUpdate()->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There are no two-seaters available for this event anymore.';
    }
}
