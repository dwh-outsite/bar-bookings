@extends('layouts.app')

@section('content')
    <div class="md:w-4/5 md:mx-auto">

        <div class="flex justify-between items-center mt-8 mb-12">
            <div>
                <h1 class="text-4xl font-light">
                    {{ $event->name }}
                </h1>
                <div class="text-gray-500 mt-2">
                    {{ $event->start->format('D d-m-Y H:i') }} -
                    {{ $event->end->format('H:i') }}
                </div>
            </div>

            <div class="md:flex">
                <div class="bg-white px-4 py-3 rounded-full shadow font-semibold uppercase tracking-wide md:mr-4 my-4 md:my-0">
                    <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
                </div>
                <div class="bg-white px-4 py-3 rounded-full shadow font-semibold uppercase tracking-wide md:mr-4 my-4 md:my-0">
                    <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
                </div>
                @if ($event->hasStarted())
                    <div class="bg-purple-200 px-4 py-3 rounded-full shadow font-semibold uppercase tracking-wide">
                        <strong>{{ $event->numberOfActualAttendees() }}</strong> visited people
                    </div>
                @else
                    <div class="bg-purple-200 px-4 py-3 rounded-full shadow font-semibold uppercase tracking-wide">
                        <strong>{{ $event->numberOfAttendees() }}</strong> people
                    </div>
                @endif
            </div>
        </div>

        @if ($event->eventType->hasWidget())
            {{ $event->eventType->widget($event)->render() }}
        @endif

        <x-bookings title="Active Bookings" :bookings="$event->bookings->filter->isActive()" :read-only="true" />
    </div>
@endsection
