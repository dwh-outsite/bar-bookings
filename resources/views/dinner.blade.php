@extends('layouts.app')

@section('content')
    <div class="md:w-4/5 md:mx-auto">

        <div class="flex items-center mt-6 mb-12">
            <h1 class="flex-1 text-4xl font-light">
                {{ $event->name }}
            </h1>
        </div>

        <div class="break-words bg-white border border-2 rounded p-6 shadow-md mb-6 text-gray-700">
            <div class="md:flex items-center">
                <div class="flex-1 flex leading-loose">
                    <div class="font-bold mr-4">
                        Start<br />
                        End
                    </div>
                    <div>
                        {{ $event->start->format('D d-m-Y H:i') }} <br />
                        {{ $event->end->format('D d-m-Y H:i') }}
                    </div>
                </div>
                <div class="md:flex">
                    <div class="border border-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide md:mr-4 my-4 md:my-0">
                        <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
                    </div>
                    <div class="border border-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide md:mr-4 my-4 md:my-0">
                        <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
                    </div>
                    <div class="bg-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
                        <strong>{{ $event->numberOfAttendees() }}</strong> people
                    </div>
                </div>
            </div>
        </div>

        @if ($event->eventType->hasWidget())
            {{ $event->eventType->widget($event)->render() }}
        @endif

        <x-bookings title="Active Bookings" :bookings="$event->bookings->filter->isActive()" :read-only="true" />
    </div>
@endsection
