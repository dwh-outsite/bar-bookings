<div>
    @if ($state !== 'inactive')
    <div class="absolute w-screen h-screen bg-black bg-opacity-75 z-50 top-0 left-0 flex items-center justify-center">
        <div class="bg-white rounded-lg overflow-hidden w-1/3 shadow-xl">
            <div class="bg-purple-500 text-gray-100 shadow px-6 py-4 text-lg flex justify-between items-center">
                <div>
                    <strong>Change booking of</strong>
                    {{ $booking->name }}
                </div>
                <button wire:click="close" class="ml-2 w-6 h-6 bg-white rounded-full font-bold text-purple-500 flex items-center justify-center text-sm">
                    ✕
                </button>
            </div>

            <div class="p-6">
                <h2 class="font-semibold text-purple-500 mb-4 tracking-wide uppercase border-b border-purple-500 pb-2">
                    Current contact details
                </h2>

                <div wire:poll>
                    <div class="mt-2">
                        <strong>Name:</strong>
                        {{ $booking->name }}
                    </div>
                    <div class="mt-2">
                        <strong>GGD Consent:</strong>
                        {{ $booking->ggd_consent ? 'Yes' : 'No' }}
                    </div>
                    <div class="mt-2">
                        <strong>Email:</strong>
                        {{ $booking->email }}
                    </div>
                    <div class="mt-2">
                        <strong>Phone Number:</strong>
                        {{ $booking->phone_number}}
                    </div>
                </div>
                <div class="text-sm text-gray-700">(updated automatically when changed on tablet)</div>

                <div class="flex space-x-4 mt-4">
                    <button wire:click="showVisitorCodeOnTablet" class="flex-1 font-bold py-3 px-6 rounded border border-purple-500 text-purple-500 hover:bg-purple-500 hover:text-white">
                        Show QR code on tablet
                    </button>
                    <button wire:click="showVisitorDetailsFormOnTablet" class="flex-1 font-bold py-3 px-6 rounded border border-purple-500 text-purple-500 hover:bg-purple-500 hover:text-white">
                        Show form on tablet
                    </button>
                </div>

                <h2 class="font-semibold text-purple-500 mt-6 mb-4 tracking-wide uppercase border-b border-purple-500 pb-2">
                    Has {{ $booking->name }} left?
                </h2>

                <div class="flex items-center">
                    <button
                        wire:click="markAsLeft({{ $booking->id }})"
                        class="font-bold py-4 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500"
                    >
                        Mark as Left
                    </button>
                    <div class="text-gray-500 ml-6 flex-1 leading-tight">
                        When the guest has left, you can mark them as "left" to free up a spot for a new guest.
                    </div>
                </div>

                <h2 class="font-semibold text-purple-500 mt-6 mb-4 tracking-wide uppercase border-b border-purple-500 pb-2">
                    Select a new table
                </h2>

                @if ($booking->ggd_consent)
                    <div class="flex space-x-2 justify-center">
                        @foreach(range(1, 8) as $i)
                            @if (optional($booking->currentTablePlacement())->table_number == $i)
                                <div class="flex items-center justify-center w-12 h-12 rounded bg-orange-500 text-white border border-orange-500 font-semibold">
                                    {{ $i }}
                                </div>
                            @else
                                <button
                                    wire:click="addNewTablePlacement({{ $i }})"
                                    class="flex items-center justify-center w-12 h-12 rounded text-orange-500 border border-orange-500 font-semibold hover:bg-orange-500 hover:text-white"
                                >
                                    {{ $i }}
                                </button>
                            @endif
                        @endforeach
                    </div>

                    <h2 class="font-semibold text-purple-500 mt-6 mb-2 tracking-wide uppercase border-b border-purple-500 pb-2">
                        Table history
                    </h2>

                    @foreach($booking->tablePlacements as $tablePlacement)
                        <div class="my-1 inline-flex items-center bg-orange-100 border border-orange-500 rounded overflow-hidden mr-1">
                            <div class="flex items-center justify-center w-8 h-8 rounded-r text-white bg-orange-500 font-semibold text-sm mr-2">
                                {{ $tablePlacement->table_number }}
                            </div>
                            <div class="pr-2 font-semibold text-sm">{{ $tablePlacement->created_at->format('H:i') }}</div>
                        </div>
                    @endforeach

                    @include('bar.tables')
                @else
                    <div class="text-gray-500 text-center leading-tight">
                        This guest did not give consent to share their information with the GGD,
                        therefore table registration is not necessary.
                    </div>
                @endif

            </div>
        </div>
    </div>
    @endif
</div>
