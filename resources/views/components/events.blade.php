<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        {{ $title }}
    </div>

    <div class="w-full">
        @forelse($events as $event)
            <a href="{{ route($area.'.events.show', $event) }}">
                <div class="p-6 border-b flex hover:bg-purple-100">
                    <div class="flex-1 flex">
                        <div class="text-gray-600 pr-5 text-right w-40">
                            {{ $event->start->format('D d-m H:i') }}
                        </div>
                        <div class="text-gray-900">{{ $event->name }}</div>
                    </div>
                    <div class="text-gray-600 hidden md:block">
                        @if ($event->hasEndDateInTheFuture())
                            {{ $event->capacity - $event->availableSeats() }} / {{ $event->capacity }}
                        @else
                            {{ $event->numberOfActualAttendees() }}
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-700 p-6 text-center">
                There are no events yet.
            </p>
        @endforelse
    </div>
</div>
