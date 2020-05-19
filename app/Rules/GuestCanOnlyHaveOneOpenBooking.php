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
        return !Booking::where('email', $value)->active()->endDateInTheFuture()->exists();
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
