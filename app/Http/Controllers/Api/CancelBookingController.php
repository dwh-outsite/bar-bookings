<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelBookingController extends Controller
{
    public function __invoke($token)
    {
        $booking = Booking::where('cancelation_token', $token)->firstOrFail();

        $booking->cancel();

        return redirect(config('app.cancelation_redirect_url'));
    }
}
