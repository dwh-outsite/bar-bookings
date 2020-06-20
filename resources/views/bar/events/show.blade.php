@extends('layouts.bar')

@section('nav-left')
    <a href="{{ route('bar.events.index') }}">
        <div class="flex items-center">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
            <span class="uppercase tracking-wide text-sm font-semibold">Go back to events overview</span>
        </div>
    </a>
@endsection

@section('content')
    <div class="h-full flex flex-col overflow-hidden">

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

        <div class="flex-1 mb-6 flex h-full touch-scrollbar">
            <div class="w-1/2 pr-2 h-full">
                <livewire:interactive-bookings title="Open Bookings" :event="$event" :filter-active="true" :filter-present="false" />
            </div>
            <div class="w-1/2 pl-2 h-full flex flex-col">
                <livewire:interactive-bookings title="Present Bookings" :event="$event" :filter-active="true" :filter-present="true" />
                <div class="pt-6"></div>
                <livewire:interactive-bookings title="Canceled Bookings" :event="$event" :filter-active="false" />
            </div>
        </div>

    </div>
@endsection
