@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    {{ $title }}
                </div>

                @isset($event)
                <form class="w-full p-6" method="POST" action="{{ route('admin.events.update', $event) }}">
                    @method('PUT')
                @else
                <form class="w-full p-6" method="POST" action="{{ route('admin.events.store') }}">
                @endif
                    @csrf

                    <div class="flex flex-wrap mb-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Name') }}:
                        </label>

                        <input id="name" type="text" class="form-input w-full @error('name') border-red-500 @enderror" name="name" value="{{ $event->name ?? old('name') }}" required>

                        @error('name')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Capacity') }}:
                        </label>

                        <input id="capacity" type="number" class="form-input w-full @error('capacity') border-red-500 @enderror" name="capacity" value="{{ $event->capacity ?? old('capacity') }}" required>

                        @error('capacity')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="start" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Start') }}:
                        </label>

                        <input id="start" type="datetime-local" class="form-input w-full @error('start') border-red-500 @enderror" name="start" value="{{ isset($event) ? $event->start->format('Y-m-d\TH:i') : old('start') }}" required>

                        @error('start')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="start" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('End') }}:
                        </label>

                        <input id="end" type="datetime-local" class="form-input w-full @error('end') border-red-500 @enderror" name="end" value="{{ isset($event) ? $event->end->format('Y-m-d\TH:i') : old('end')}}" required>

                        @error('end')
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-block align-middle text-center select-none border font-bold whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700">
                        {{ __('Save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
