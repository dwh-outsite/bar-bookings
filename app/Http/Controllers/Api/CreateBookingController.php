<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\EventMustHaveTwoseatCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBookingPerEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $booking = Booking::create($request->validate(Booking::rules($request->event_id)));

            Mail::to($booking->email)->queue(new BookingConfirmation($booking));

            return response([], 201);

        });
    }
}
