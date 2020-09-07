<div>
    <div class="break-words bg-white border border-2 rounded shadow-md w-full mb-6">

        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between">
            Tafelregistratie
        </div>

        <div class="p-6">

            @if (session()->has('message'))
                <div id="alert" class="bg-purple-200 text-purple-800 p-3 rounded-lg font-semibold mb-3">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex space-x-2 justify-center flex-wrap">
                @foreach(range(1, 8) as $i)
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
            Tafelhistorie
        </div>

        <div class="p-6 text-left">
            <div class="flex flex-wrap">
                @foreach($booking->tablePlacements as $tablePlacement)
                    <div class="w-1/2">
                        <div class="my-1 inline-flex items-center bg-orange-100 border border-orange-500 rounded overflow-hidden">
                            <div class="flex items-center justify-center w-8 h-8 rounded-r text-white bg-orange-500 font-semibold text-sm mr-2">
                                {{ $tablePlacement->table_number }}
                            </div>
                            <div class="pr-2 font-semibold text-sm">{{ $tablePlacement->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @endforeach
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
