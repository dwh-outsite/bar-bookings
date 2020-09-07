<div class="break-words bg-white border border-2 rounded shadow-md">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between">
        Enter Personal Code
    </div>

    <div class="p-6">

        <div class="flex flex-wrap mb-6">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                Bezoekerscode / Visitor Code
                <span class="text-red-500">*</span>
            </label>

            <input id="visitor_code" type="text" class="form-input border-none w-full bg-gray-100 h-16 @error('visitor_code') border-red-500 @enderror" wire:model="visitor_code" value="{{ old('visitor_code') }}" placeholder="Visitor Code" required>

            @error('visitor_code')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <button wire:click="submit" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
            Ga door / Continue
        </button>

    </div>
</div>
