@extends('layouts.app')

@section('content')
    <div class="md:w-4/5 md:mx-auto">

        <div class="flex items-center mt-6 mb-12">
            <h1 class="flex-1 text-4xl font-light">
                {{ $event->name }}
            </h1>
            <a href="{{ route('admin.events.edit', $event) }}">
                <button class="font-bold py-2 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500">
                    Edit
                </button>
            </a>
        </div>

        @if (session('status'))
            <div class="text-sm shadow rounded text-white bg-green-500 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="break-words bg-white border border-2 rounded p-6 shadow-md mb-6 text-gray-700">
            <div class="md:flex items-center">
                <div class="flex-1 flex leading-loose">
                    <div class="font-bold mr-4">
                        Start<br />
                        End
                    </div>
                    <div>
                        {{ $event->start->format('d-m-Y H:i') }} <br />
                        {{ $event->end->format('d-m-Y H:i') }}
                    </div>
                </div>
                <div class="md:flex">
                    <div class="border border-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide md:mr-4 my-4 md:my-0">
                        <strong>{{ $event->twoseat_capacity - $event->availableTwoseats()  }} / {{ $event->twoseat_capacity }}</strong> two-seats
                    </div>
                    <div class="bg-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide">
                        <strong>{{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}</strong> bookings
                    </div>
                </div>
            </div>
        </div>

        @if ($event->eventType->hasWidget())
            {{ $event->eventType->widget($event)->render() }}
        @endif

        <x-bookings title="Active Bookings" :bookings="$event->bookings->filter->isActive()" />
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
