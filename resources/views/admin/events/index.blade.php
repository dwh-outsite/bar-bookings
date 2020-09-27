@extends('layouts.app')

@section('content')
    <div class="md:w-4/5 md:mx-auto">

        <div class="flex items-center mt-8 mb-12">
            <h1 class="flex-1 text-4xl font-light">
                Events
            </h1>
            <a href="{{ route('admin.events.create') }}">
                <button class="font-bold py-3 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500 uppercase text-xs tracking-widest">
                    Create New Event
                </button>
            </a>
        </div>

        @if (session('status'))
            <div class="text-sm shadow rounded text-white bg-green-500 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <x-events title="Upcoming Events" :events="$futureEvents" />

        <x-events title="Past Events" :events="$pastEvents" />

    </div>
@endsection
