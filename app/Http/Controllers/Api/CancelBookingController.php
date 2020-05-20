<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Mail\BookingCanceled;
use Illuminate\Support\Facades\Mail;

class CancelBookingController extends Controller
{
    public function __invoke($token)
    {
        $booking = Booking::where('cancelation_token', $token)->firstOrFail();

        $booking->cancel();

        Mail::to($booking->email)->queue(new BookingCanceled($booking));

        return redirect(config('app.cancelation_redirect_url'));
    }
}
