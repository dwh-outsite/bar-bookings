<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\EventMustHaveTwoseatCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $booking = Booking::create($request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', new GuestCanOnlyHaveOneOpenBooking],
                'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft],
                'twoseat' => ['boolean', new EventMustHaveTwoseatCapacityLeft($request->event_id)],
            ]));

            Mail::to($booking->email)->queue(new BookingConfirmation($booking));

            return response([], 201);

        });
    }
}
