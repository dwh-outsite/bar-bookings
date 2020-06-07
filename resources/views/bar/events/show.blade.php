@extends('layouts.bar')

@section('content')
    <div>

        <div class="flex items-center mt-6">
            <h1 class="flex-1 text-4xl font-light">
                {{ $event->name }}
            </h1>
            <div class="flex">
                <div class="bg-white border border-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide mr-4">
                    <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
                </div>
                <div class="bg-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
                    <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
                </div>
            </div>
        </div>

        <p class="text-gray-500 mt-2 mb-12">
            {{ $event->start->format('d-m-Y H:i') }} -
            {{ $event->end->format('d-m-Y H:i') }}
        </p>

        <x-interactive-bookings title="Active Bookings" :bookings="$event->bookings->filter->isActive()" />
        <x-interactive-bookings title="Canceled Bookings" :bookings="$event->bookings->filter->isCanceled()" />
    </div>
@endsection
