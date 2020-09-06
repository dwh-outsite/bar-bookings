<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Event;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        $event = Event::find($request->input('event_id'));

        if ($event == null) {
            throw ValidationException::withMessages(['event_id' => ['This event does not exist']]);
        }

        return DB::transaction(function () use ($request, $event) {

            $booking = Booking::create($request->validate(Booking::rules($event)));

            Mail::to($booking->email)->queue(new BookingConfirmation($booking));

            return response([], 201);

        });
    }
}
