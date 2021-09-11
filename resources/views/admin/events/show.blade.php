@extends('layouts.app')

@section('content')
    <div class="md:w-4/5 md:mx-auto">

        <div class="md:flex justify-between items-center mt-8 mb-12">
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

            <a href="{{ route('admin.events.edit', $event) }}">
                <button class="mt-4 md:mt-0 font-bold py-2 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500">
                    Edit
                </button>
            </a>
        </div>

        @if (session('status'))
            <div class="text-sm shadow rounded text-white bg-green-500 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($event->eventType->hasWidget())
            {{ $event->eventType->widget($event)->render() }}
        @endif

        <x-bookings title="Open Bookings" :bookings="$event->bookings->filter->isActive()->reject->isPresent()" />
        <x-bookings title="Present" :bookings="$event->bookings->filter->isActive()->filter->isPresent()" />
        <x-bookings title="Left" :bookings="$event->bookings->filter->hasLeft()" />
        <x-bookings title="Canceled Bookings" :bookings="$event->bookings->filter->isCanceled()" />

        <a href="{{ route('admin.events.destroy', $event) }}"
           class="underline text-sm text-gray-700 pb-6"
           onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this event? NOTE: Deleting an event will cancel all bookings and notify guests by e-mail.')) { document.getElementById('delete-form').submit(); }"
        >
            Delete this event
        </a>
        <form id="delete-form" action="{{ route('admin.events.destroy', $event) }}" method="POST" class="hidden">
            @method('delete')
            @csrf
        </form>
    </div>
@endsection
