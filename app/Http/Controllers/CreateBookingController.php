<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Rules\EventMustHaveCapacityLeft;
use App\Rules\GuestCanOnlyHaveOneOpenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateBookingController extends Controller
{
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {

            Booking::create($request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', new GuestCanOnlyHaveOneOpenBooking],
                'event_id' => ['required', 'integer', new EventMustHaveCapacityLeft],
            ]));

            return response([], 201);

        });
    }
}
