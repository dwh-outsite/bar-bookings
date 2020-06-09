@extends('layouts.bar')

@section('content')
    <div>

        <div class="flex items-center mt-6 mb-12">
            <h1 class="flex-1 text-4xl font-light">
                Events
            </h1>
        </div>

        @if (session('status'))
            <div class="text-sm shadow rounded text-white bg-green-500 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <x-events title="Select an event to view its bookings" :events="$futureEvents" area="bar" />

    </div>
@endsection
