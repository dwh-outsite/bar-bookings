@component('mail::message')
# Bedankt voor het reserveren / Thank you for booking

Je hebt gereserveerd voor **{{ $booking->event->name }}** op **{{ $booking->event->start->format('d-m-Y')  }}** om
**{{ $booking->event->start->format('H:i')  }}** uur.
@if($booking->twoseat)
Je hebt aangegeven dat je met **twee personen** komt en dat jullie samen binnen 1,5 meter mogen zijn.
@endif

You succesfully made a booking for **{{ $booking->event->name }}** on **{{ $booking->event->start->format('d-m-Y')  }}**
at **{{ $booking->event->start->format('H:i')  }}** uur.
@if($booking->twoseat)
You have indicated that you are coming with **two persons** and that you are allowed to be together within 1.5 meter.
@endif

{{ $booking->event->email_text }}

@component('mail::panel')

## Reservering Annuleren / Cancel Booking

Als het gekozen tijdstip je tóch niet schikt, annuleer dan alsjeblieft je reservering.
Hiermee geef je jouw plek binnen het tijdslot weer vrij zodat een ander er gebruik van maken.
Door je huidige reservering te annuleren heb je ook direct weer de mogelijkheid een nieuwe reservering te maken.

If you are not available at the chosen time after all, please consider canceling your booking.
By canceling you free up your spot for someone else to use.
Also, you immediately get the ability to make a new booking for a different timeslot.

@component('mail::button', ['url' => $booking->cancelationUrl(), 'color' => 'red'])
Annuleer Reservering / Cancel Booking
@endcomponent

@endcomponent

**Stay safe!**

{{ config('app.name') }}
@endcomponent
