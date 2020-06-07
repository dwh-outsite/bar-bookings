<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        {{ $title }}
    </div>

    <div class="w-full">
        @forelse($bookings->sortBy->name as $booking)
            <div class="p-6 border-b flex items-center hover:bg-purple-100">
                <div class="flex-1 flex items-center">
                    {{ $booking->name }}
                    @if($booking->twoseat)
                        <div class="bg-orange-200 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                            two-seat
                        </div>
                    @endif
                </div>
                <div class="w-1/6 text-right">
                    @if($booking->isActive())
                        test
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
