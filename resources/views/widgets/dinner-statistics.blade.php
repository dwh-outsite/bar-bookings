<div class="md:flex">

    <div class="flex-1 mr-2 flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">
        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
            Diets
        </div>

        <div class="w-full p-6">
            <div class="flex flex-wrap -m-1">
                @foreach ($diets as $diet => $count)
                    <div class="w-1/2 md:w-1/4 my-1">
                        <div class="flex flex-col justify-between bg-purple-200 rounded p-3 mx-1 h-full">
                            <div class="font-semibold text-purple-600 text-sm tracking-wider uppercase mb-3">
                                {{ Str::limit($diet, 10) }}
                            </div>
                            <div class="font-bold text-xl text-purple-600">
                                {{ $count }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex-1 ml-2 flex flex-col break-words bg-white border border-2 rounded shadow-md mb-6">
        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
            Teams
        </div>

        <div class="w-full p-6 leading-loose">
            @foreach ($teams as $team => $count)
                <div class="flex">
                    <div class="w-10">{{ $count }}</div>
                    <div class="font-bold">{{ $team }}</div>
                </div>
            @endforeach
        </div>
    </div>

</div>
