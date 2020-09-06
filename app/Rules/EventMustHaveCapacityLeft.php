<?php

namespace App\Rules;

use App\Event;
use Illuminate\Contracts\Validation\Rule;

class EventMustHaveCapacityLeft implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $event = Event::find($value);

        if ($event == null) {
            return false;
        }

        return $event->capacity - $event->bookings()->active()->lockForUpdate()->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There are no seats available for this event anymore.';
    }
}
