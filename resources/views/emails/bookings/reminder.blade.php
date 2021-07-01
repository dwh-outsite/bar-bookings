@component('mail::message')
# Tot later vandaag! / We're looking forward to see you!

Dit is een vriendelijke herinnering voor je reservering vandaag voor **{{ $booking->event->name }}** om
**{{ $booking->event->start->format('H:i')  }}** uur.
@if($booking->twoseat)
Je hebt aangegeven dat je met **twee personen** komt en dat jullie samen binnen 1,5 meter mogen zijn.
@endif
Mocht je niet meer kunnen komen, laat het dan alsjeblieft even weten door je reservering te annuleren onderaan deze
mail.

This is a friendly reminder for your booking for **{{ $booking->event->name }}** which starts Today
at **{{ $booking->event->start->format('H:i')  }}**.
@if($booking->twoseat)
You have indicated that you are coming with **two persons** and that you are allowed to be together within 1.5 meter.
@endif
In case you cannot make it, please cancel your booking using the button below.

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
