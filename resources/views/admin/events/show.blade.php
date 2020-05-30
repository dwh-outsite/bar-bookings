@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="break-words bg-white border border-2 rounded p-6 shadow-md mb-6 text-gray-700">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold mb-6">
                            {{ $event->name }}
                        </h1>
                        <div class="flex leading-loose">
                            <div class="font-bold mr-4">
                                Start<br />
                                End
                            </div>
                            <div>
                                {{ $event->start->format('d-m-Y H:i') }} <br />
                                {{ $event->end->format('d-m-Y H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin.events.edit', $event) }}">
                            <button class="font-bold py-2 px-4 rounded leading-normal text-purple-500 border border-purple-500 hover:text-white hover:bg-purple-500">
                                Edit
                            </button>
                        </a>

                        <div class="bg-purple-200 px-4 py-3 rounded-full font-semibold uppercase tracking-wide mt-6">
                            <strong>{{ $event->bookings->count() }} / {{ $event->capacity }}</strong> bookings
                        </div>
                    </div>
                </div>
            </div>

            <x-bookings title="Active Bookings" :bookings="$event->bookings->filter->isActive()" />
            <x-bookings title="Canceled Bookings" :bookings="$event->bookings->filter->isCanceled()" />

            <a href="{{ route('admin.events.destroy', $event) }}"
               class="underline text-sm text-gray-700"
               onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this event? NOTE: Deleting an event will cancel all bookings and notify guests by e-mail.')) { document.getElementById('delete-form').submit(); }"
            >
                Delete this event
            </a>
            <form id="delete-form" action="{{ route('admin.events.destroy', $event) }}" method="POST" class="hidden">
                @method('delete')
                @csrf
            </form>
        </div>
    </div>
@endsection
