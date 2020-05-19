@component('mail::message')
# Bedankt voor het reserveren / Thank you for booking

Je hebt gereserveerd voor **{{ $booking->event->name }}** op **{{ $booking->event->start  }}**.

@component('mail::button', ['url' => '', 'color' => 'red'])
Annuleer Reservering / Cancel Booking
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
