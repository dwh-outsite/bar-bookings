<?php

namespace App\Rules;

use App\Event;
use Illuminate\Contracts\Validation\Rule;

class EventMustHaveTwoseatCapacityLeft implements Rule
{
    private $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
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

        $event = Event::find($this->eventId);

        if ($event == null) {
            return false;
        }

        return $event->twoseat_capacity - $event->bookings()->twoseat()->active()->lockForUpdate()->count() > 0;
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
