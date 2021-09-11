<div class="md:flex space-y-2 md:space-y-0 md:space-x-4" wire:poll>
    <div class="bg-white shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
        <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
    </div>
    <div class="bg-white shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
        <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
    </div>
    <div class="bg-purple-200 shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
        <strong>{{ $event->numberOfAttendees() }}</strong> people
    </div>
</div>
