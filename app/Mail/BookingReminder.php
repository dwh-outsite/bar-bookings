<?php

namespace App\Mail;

use App\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this
            ->subject(
                "Reserveringsherinnering / Booking Reminder - {$this->booking->event->name} ".
                "[{$this->booking->event->start->format('D d-m-Y H:i')}]")
            ->markdown('emails.bookings.reminder');
    }
}
