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
                <button
                    wire:click="markAsLeft({{ $booking->id }})"
                    class="font-bold py-4 px-4 rounded leading-normal text-purple-500 border border-purple-500 bg-white hover:text-white hover:bg-purple-500"
                >
                    Mark as Left
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
