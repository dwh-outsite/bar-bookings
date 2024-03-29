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
    <livewire:welcome-dialog :event="$event" />
    <livewire:change-dialog />

    <div class="h-full md:flex flex-col md:overflow-hidden">

        <div class="md:flex justify-between items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex-1">
                <h1 class="text-4xl font-light">
                    {{ $event->name }}
                </h1>
                <div class="text-gray-500 mt-2">
                    {{ $event->start->format('D d-m-Y H:i') }} -
                    {{ $event->end->format('H:i') }} |

                    <a href="{{ route('bar.events.index') }}">
                        <span class="underline">Select other event</span>
                    </a>
                </div>
            </div>
            <livewire:counters :event="$event" />
            <div class="flex-1 text-right">
                <livewire:register-new-guest-button />
            </div>
        </div>

        <div class="flex-1 mb-6 md:flex md:h-full touch-scrollbar space-y-4 md:space-y-0">
            <div class="md:w-1/3 md:pr-2 md:h-full">
                <livewire:interactive-bookings title="Open Bookings" :event="$event" :filter-active="true" :filter-present="false" />
            </div>
            <div class="md:w-1/3 md:px-2 md:h-full">
                <livewire:interactive-bookings title="Present" :event="$event" :filter-active="true" :filter-present="true" :filter-left="false" />
            </div>
            <div class="md:w-1/3 md:pl-2 md:h-full md:flex flex-col space-y-4">
                <livewire:interactive-bookings title="Left" :event="$event" :filter-left="true" />
                <livewire:interactive-bookings title="Canceled Bookings" :event="$event" :filter-left="false" :filter-active="false" />
            </div>
        </div>

    </div>
@endsection
