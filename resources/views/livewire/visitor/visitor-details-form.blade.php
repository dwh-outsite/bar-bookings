<div class="break-words bg-white border border-2 rounded shadow-md">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 flex justify-between">
        Persoonlijke Gegevens
    </div>

    <div class="p-6">

        <div class="flex flex-wrap mb-6">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                Naam / Name
                <span class="text-red-500">*</span>
            </label>

            <input id="name" type="text" class="form-input border-none w-full bg-gray-100 h-16 @error('name') border-red-500 @enderror" wire:model="name" value="{{ old('name') }}" placeholder="Name" required>

            @error('name')
            <p class="text-red-500 text-xs italic mt-4">
                {{ $message }}
            </p>
            @enderror
        </div>

        <label for="ggd_consent" class="block bg-purple-200 rounded p-4 font-semibold flex-1 flex mb-6">
            <input id="ggd_consent" type="checkbox" class="form-checkbox h-8 w-8 mr-3 text-purple-500 @error('ggd_consent') border-red-500 @enderror focus:outline-none" wire:model="ggd_consent" value="true" required>
            <div class="leading-tight">
                Geef je toestemming om je gegevens te delen met de GGD wanneer deze worden opgevraagd voor van een bron- en contactonderzoek?
                <div class="text-sm mt-1 font-normal">
                    Do you consent to share your information with the municipal health service (GGD) to support contact tracing if requested?
                </div>
            </div>
        </label>

        @if ($ggd_consent)
            <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    E-mail Adres / Email Address
                </label>

                <input id="email" type="email" class="form-input border-none w-full bg-gray-100 h-16  @error('email') border-red-500 @enderror" wire:model="email" value="{{ old('email') }}" placeholder="Email Address">

                @error('email')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    Telefoonnummer / Phone Number
                </label>

                <input id="phone_number" type="phone_number" class="form-input border-none w-full bg-gray-100 h-16  @error('phone_number') border-red-500 @enderror" wire:model="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">

                @error('phone_number')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>
        @endif

        <button wire:click="update" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
            Opslaan / Save
        </button>

    </div>
</div>
