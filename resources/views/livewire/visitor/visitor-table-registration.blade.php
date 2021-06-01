<div>
    <div class="break-words bg-white border border-2 rounded shadow-md w-full mb-6">

        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between">
            Nieuwe Tafel / New Table
        </div>

        <div class="p-6">
            <div class="text-left text-sm text-gray-800 leading-tight">
                <div class="mb-2">
                    Als onderdeel van de gegevens voor bron- en contactonderzoek voor de GGD kun je hieronder de placering
                    bijhouden door op je tafelnummer te klikken of door de QR code op tafel te scannen.
                </div>
                <div class="mb-2 text-gray-600">
                    As part of the data that is shared with the GGD for contact tracing, you can register your table by
                    clicking your table number or by scanning the QR code on the table.
                </div>
            </div>

            @if (session()->has('message'))
                <div id="alert" class="bg-purple-200 text-purple-800 p-3 rounded-lg font-semibold mb-3">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex space-x-2 justify-center flex-wrap">
                @foreach(range(1, 9) as $i)
                    @if (optional($booking->currentTablePlacement())->table_number == $i)
                        <div class="flex items-center justify-center w-12 h-12 my-2 rounded bg-orange-500 text-white border border-orange-500 font-semibold">
                            {{ $i }}
                        </div>
                    @else
                        <button
                            wire:click="addNewTablePlacement({{ $i }})"
                            class="flex items-center justify-center w-12 h-12 my-2 rounded text-orange-500 border border-orange-500 font-semibold hover:bg-orange-500 hover:text-white"
                        >
                            {{ $i }}
                        </button>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
    <div class="break-words bg-white border border-2 rounded shadow-md w-full">

        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between">
            Tafelhistorie / Table Log
        </div>

        <div class="p-6 text-left">
            <div class="flex flex-wrap">
                @forelse($booking->tablePlacements as $tablePlacement)
                    <div class="w-1/2">
                        <div class="my-1 inline-flex items-center bg-orange-100 border border-orange-500 rounded overflow-hidden">
                            <div class="flex items-center justify-center w-8 h-8 rounded-r text-white bg-orange-500 font-semibold text-sm mr-2">
                                {{ $tablePlacement->table_number }}
                            </div>
                            <div class="pr-2 font-semibold text-sm">{{ $tablePlacement->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center w-full text-sm leading-tight">
                        <div class="text-gray-800">Je hebt je tafel nog niet geregistreerd.</div>
                        <div class="text-gray-600">You have not registered your table yet.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', event => {
            @this.on('visitor-table-registered', function () {
                window.history.replaceState({}, document.title, window.location.href.split('?')[0]);

                window.setTimeout(function () {
                    document.getElementById('alert').style.display = 'none';
                }, 5000);
            });
        });
    </script>
@endpush
