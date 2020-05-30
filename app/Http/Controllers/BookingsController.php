<?php

namespace App\Http\Controllers;

use App\Booking;

class BookingsController extends Controller
{
    public function destroy(Booking $booking)
    {
        $booking->cancel();

        return back()->with('status', 'Booking of "'.$booking->name.'" has been canceled successfully. A cancelation e-mail will be sent to the guest.');
    }
}
