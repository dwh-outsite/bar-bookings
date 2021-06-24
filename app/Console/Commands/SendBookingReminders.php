<?php

namespace App\Console\Commands;

use App\Booking;
use App\Mail\BookingReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBookingReminders extends Command
{
    protected $signature = 'bookings:remind';
    protected $description = 'Send a booking reminder to the visitors.';

    public function handle()
    {
        Booking::query()
            ->whereHas('event', fn($query) => $query->where('start', '<', now()->addHours(6)))
            ->where('created_at', '<', today())
            ->whereNull('reminded_at')
            ->get()
            ->each(function (Booking $booking) {
                $booking->update(['reminded_at' => now()]);
                echo 'email henk';
                return Mail::to($booking->email)->queue(new BookingReminder($booking));
            });

        return 0;
    }
}
