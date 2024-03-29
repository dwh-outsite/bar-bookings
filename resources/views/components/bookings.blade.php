<div class="flex flex-col break-words bg-white rounded shadow-lg mb-8 overflow-hidden">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between items-center">
        {{ $title }}

        <span class="bg-gray-500 text-white rounded-full font-semibold text-xs px-2 py-1">
            {{ $bookings->count() }}
        </span>
    </div>

    <div class="w-full">
        @forelse($bookings->sortBy('name', SORT_STRING | SORT_FLAG_CASE) as $booking)
            <div class="p-6 pb-4 border-t border-gray-200 hover:bg-purple-100">
                <div class="md:flex items-center">
                    <div class="md:w-2/6 mb-2">
                        <div class="flex items-center">
                            @if ($booking->event->hasStarted())
                                @if ($booking->isPresent())
                                    <div class="w-2 h-2 rounded-full bg-green-400 mr-2"></div>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-red-400 mr-2"></div>
                                @endif
                            @endif
                            {{ $booking->name }}
                            @if ($booking->twoseat)
                                <div class="bg-orange-200 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                                    two-seat
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (!$readOnly)
                        <div class="text-gray-700 md:w-2/6 mb-2 flex items-center">
                            {{ $booking->email }}
                            @if ($booking->ggd_consent)
                                <div class="border border-gray-700 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                                    GGD
                                </div>
                            @endif
                        </div>
                        <div class="text-gray-700 md:w-1/6 mb-2">{{ $booking->created_at->format('d-m-Y H:i:s') }}</div>
                        <div class="md:w-1/6 md:text-right mb-2">
                            @if ($booking->isActive())
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
                    @endif
                </div>
                <div class="@if ($readOnly) mt-2 @endif -mx-1 flex">
                    @if (!is_null($booking->custom_fields))
                        @foreach($booking->custom_fields as $name => $value)
                            @if (!empty($value))
                                <div class="bg-purple-200 px-2 py-1 rounded-full text-xs mx-1">
                                    <span class="font-semibold uppercase">{{ $name }}</span>
                                    {{ is_array($value) ? implode(', ', $value) : $value }}
                                </div>
                            @endif
                        @endforeach
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
