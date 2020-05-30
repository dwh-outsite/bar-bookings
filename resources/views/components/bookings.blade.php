<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        {{ $title }}
    </div>

    <div class="w-full">
        @forelse($bookings->sortBy->name as $booking)
            <div class="p-6 border-b flex hover:bg-purple-100">
                <div class="w-2/6">{{ $booking->name }}</div>
                <div class="text-gray-700 w-2/6">{{ $booking->email }}</div>
                <div class="text-gray-700 w-1/6">{{ $booking->created_at->format('d-m-Y H:i:s') }}</div>
                <div class="w-1/6 text-right">
                    @if($booking->isActive())
                        Cancel
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-700 p-6 text-center">
                There are no bookings yet.
            </p>
        @endforelse
    </div>
</div>
