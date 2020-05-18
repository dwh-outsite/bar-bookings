<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBooking;
use Illuminate\Http\Request;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        // TODO: Wrap in database transaction in case of race conditions

        Booking::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', new GuestCanOnlyHaveOneOpenBooking],
            'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft()],
        ]));

        return response([], 201);
    }
}
