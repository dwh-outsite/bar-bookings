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

        <div class="flex items-center mt-6 mb-12">
            <div class="flex-1">
                <h1 class="text-4xl font-light">
                    {{ $event->name }}
                </h1>
                <p class="text-gray-500 mt-2">
                    {{ $event->start->format('D d-m-Y H:i') }} -
                    {{ $event->end->format('D d-m-Y H:i') }}
                </p>
            </div>
            <livewire:counters :event="$event" />
        </div>

        <div class="flex-1 mb-6 flex h-full touch-scrollbar">
            <div class="w-1/3 pr-2 h-full">
                <livewire:interactive-bookings title="Open Bookings" :event="$event" :filter-active="true" :filter-present="false" />
            </div>
            <div class="w-1/3 px-2 h-full">
                <livewire:interactive-bookings title="Present Bookings" :event="$event" :filter-active="true" :filter-present="true" />
            </div>
            <div class="w-1/3 pl-2 h-full flex flex-col">
                <livewire:create-booking :event="$event" />
                <div class="pt-6"></div>
                <div class="h-64">
                    <livewire:interactive-bookings title="Canceled Bookings" :event="$event" :filter-active="false" />
                </div>
            </div>
        </div>

    </div>
@endsection
