<div class="flex flex-col h-full break-words bg-white rounded overflow-hidden shadow-md">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 pl-6 pr-3 flex justify-between items-center">
        <span class="uppercase text-sm tracking-wider">{{ $title }}</span>

        <span class="bg-gray-500 text-white rounded-full font-semibold text-xs px-2 py-1">
            {{ $visibleBookings->count() }}
        </span>
    </div>

    <div class="flex-1-1-0 overflow-auto" wire:poll>
        @forelse($visibleBookings->sortBy->name as $booking)
            <div class="px-6 py-3 border-b flex items-center hover:bg-purple-100">
                <div class="flex-1 flex items-center">
                    @if ($booking->isPresent() && !$booking->hasLeft())
                        <div
                            class="
                                flex items-center justify-center w-6 h-6 rounded border
                                @if ($booking->ggd_consent) border-orange-500 text-orange-500 @else border-gray-300 text-gray-300 @endif
                                font-semibold text-sm mr-2
                            "
                        >
                            @if (is_null($booking->currentTablePlacement()))
                                -
                            @else
                                {{ $booking->currentTablePlacement()->table_number }}
                            @endif
                        </div>
                    @endif
                    {{ $booking->name }}
                    @if ($booking->twoseat)
                        <div class="bg-orange-200 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                            two-seat
                        </div>
                    @endif
                    @if (\Illuminate\Support\Str::contains($booking->email, 'kennismaken'))
                        <div class="bg-orange-200 px-2 py-1 rounded-full uppercase tracking-wide text-xs ml-2 font-semibold">
                            KMG
                        </div>
                    @endif
                </div>
                <div>
                    @if(!$booking->present)
                        <button
                            wire:click="markAsPresent({{ $booking->id }})"
                            class="@if($booking->isCanceled()) invisible @endif font-bold py-4 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500 uppercase text-xs tracking-widest"
                        >
                            Mark as Present
                        </button>
                    @else
                        <button
                            wire:click="change({{ $booking->id }})"
                            class="@if($booking->isCanceled() || $booking->hasLeft()) invisible @endif font-bold py-4 px-4 rounded leading-normal text-purple-500 hover:text-white hover:bg-purple-500 uppercase text-xs tracking-widest"
                        >
                            Update
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="h-full flex items-center justify-center">
                <p class="text-gray-700 p-6 text-center">
                    There are no bookings to show.
                </p>
            </div>
        @endforelse
    </div>
</div>
