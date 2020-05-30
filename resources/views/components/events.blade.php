<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        {{ $title }}
    </div>

    <div class="w-full">
        @forelse($events as $event)
            <a href="{{ route('admin.events.show', $event) }}">
                <div class="text-gray-700 p-6 border-b flex hover:bg-purple-100">
                    <div class="w-32">
                        {{ $event->start->format('d-m H:i') }}
                    </div>
                    {{ $event->name }}
                </div>
            </a>
        @empty
            <p class="text-gray-700 p-6 text-center">
                There are no events yet.
            </p>
        @endforelse
    </div>
</div>
