@component('mail::message')
# Reservering geannuleerd / Booking canceled

Je reservering voor **{{ $booking->event->name }}** op **{{ $booking->event->start  }}** is geannuleerd op jouw verzoek.

Your booking for **{{ $booking->event->name }}** at **{{ $booking->event->start  }}** has been canceled per your request.

@endcomponent
