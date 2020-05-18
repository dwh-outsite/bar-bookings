<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Rules\GuestCanOnlyHaveOneOpenBooking;
use Illuminate\Http\Request;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        Booking::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', new GuestCanOnlyHaveOneOpenBooking],
            'event_id' => ['required', 'integer'],
        ]));

        return response([], 201);
    }
}
