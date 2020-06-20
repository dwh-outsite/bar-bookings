<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        {{ $title }}
    </div>

    <div class="w-full">
        @forelse($bookings->sortBy->name as $booking)
            <div class="p-6 pb-4 border-b md:flex items-center hover:bg-purple-100">
                <div class="md:w-2/6 flex items-center mb-2">
                    {{ $booking->name }}
                    @if($booking->twoseat)
                        <div class="bg-orange-200 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                            two-seat
                        </div>
                    @endif
                </div>
                <div class="text-gray-700 md:w-2/6 mb-2">{{ $booking->email }}</div>
                <div class="text-gray-700 md:w-1/6 mb-2">{{ $booking->created_at->format('d-m-Y H:i:s') }}</div>
                <div class="md:w-1/6 md:text-right mb-2">
                    @if($booking->isActive())
                        <form
                            action="{{ route('admin.bookings.destroy', $booking) }}"
                            method="POST"
                            onsubmit="return confirm('Do you really want to cancel the booking of {{ $booking->name }}? NOTE: The guest will receive a cancelation confirmation by e-mail.');"
                        >
                            @method('delete')
                            @csrf

                            <button class="text-red-300 hover:text-red-500">Cancel</button>
                        </form>
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
