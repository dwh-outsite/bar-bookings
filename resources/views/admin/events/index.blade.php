@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            <div class="flex items-center mt-6 mb-12">
                <h1 class="flex-1 text-4xl font-light">
                    Events
                </h1>
                <a href="{{ route('admin.events.create') }}">
                    <button class="font-bold py-2 px-4 rounded leading-normal text-purple-500 bg-white border border-purple-500 hover:text-white hover:bg-purple-500">
                        Create New Event
                    </button>
                </a>
            </div>

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <x-events title="Upcoming Events" :events="$futureEvents" />

            <x-events title="Past Events" :events="$pastEvents" />

        </div>
    </div>
@endsection
