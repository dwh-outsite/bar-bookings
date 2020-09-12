<div class="flex" wire:poll>
    <div class="bg-white shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide mr-4">
        <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
    </div>
    <div class="bg-white shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide mr-4">
        <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
    </div>
    <div class="bg-purple-200 shadow px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
        <strong>{{ $event->numberOfAttendees() }}</strong> people
    </div>
</div>
