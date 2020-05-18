<?php

namespace App\Rules;

use App\Booking;
use Illuminate\Contracts\Validation\Rule;

class GuestCanOnlyHaveOneOpenBooking implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // TODO: Check if booking was in the past

        return !Booking::where('email', $value)->exists();
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
