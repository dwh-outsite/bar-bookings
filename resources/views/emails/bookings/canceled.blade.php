@component('mail::message')
# Reservering geannuleerd / Booking canceled

Je reservering voor **{{ $booking->event->name }}** op **{{ $booking->event->start->format('d-m-Y H:i')  }}**.
Was deze annulering onterecht? Neem alsjeblieft contact op met ons of plaats een nieuwe reservering.

Your booking for **{{ $booking->event->name }}** at **{{ $booking->event->start->format('d-m-Y H:i')  }}**.
Did you not mean to cancel your booking? Please contact us or make a new booking.

@endcomponent
