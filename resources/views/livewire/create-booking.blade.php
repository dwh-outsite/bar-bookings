<div class="flex flex-col h-full break-words bg-white border border-2 rounded shadow-md">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        Register a guest
    </div>

    <div class="flex-1-1-0 overflow-auto">
        <form class="w-full p-6 flex flex-col h-full justify-between" wire:submit.prevent="create">

            @error('event_id')
            <p class="text-red-500 text-xs italic mb-4">
                {{ $message }}
            </p>
            @enderror

            <div class="flex flex-wrap mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('Name') }}
                    <span class="text-red-500">*</span>
                </label>

                <input id="name" type="text" class="form-input border-none w-full bg-gray-100 h-16 @error('name') border-red-500 @enderror" wire:model="name" value="{{ old('name') }}" placeholder="Name" required>

                @error('name')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('Email Address') }}
                </label>

                <input id="email" type="email" class="form-input border-none w-full bg-gray-100 h-16  @error('email') border-red-500 @enderror" wire:model="email" value="{{ old('email') }}" placeholder="Email Address">
                <p class="mt-2 text-sm text-gray-600">The email address is used to contact a guest in case of a COVID-19 infection.</p>

                @error('email')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="flex flex-wrap mb-6">
                <div class="flex w-full">
                    <label for="twoseat-false" class="block bg-purple-200 rounded p-4 font-semibold flex-1 mr-2">
                        <input id="twoseat-false" type="radio" class="form-radio h-8 w-8 mr-2 text-purple-500 @error('twoseat') border-red-500 @enderror" wire:model="twoseat" value="false" required>
                        Individual Seat
                    </label>

                    <label for="twoseat-true" class="block bg-purple-200 rounded p-4 font-semibold flex-1 flex ml-2">
                        <input id="twoseat-true" type="radio" class="form-radio h-8 w-8 mr-2 text-purple-500 @error('twoseat') border-red-500 @enderror" wire:model="twoseat" value="true" required>
                        <div>
                            Two-person Seat
                            <div class="text-sm mt-1 font-normal">Within 1.5 metres</div>
                        </div>
                    </label>
                </div>

                @error('twoseat')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex justify-between">
                <div>
                    @if (session()->has('message'))
                        <div id="create-booking-alert" class="inline-block py-4 px-6 rounded leading-normal bg-green-100 py-4 px-6 rounded">
                            {{ session('message') }}
                        </div>
                        <script>
                            window.setTimeout(function () {
                                document.getElementById('create-booking-alert').remove()
                            }, 3000)
                        </script>
                    @endif
                </div>
                <button type="submit" class="inline-block align-middle text-center select-none border font-bold whitespace-no-wrap py-4 px-6 rounded leading-normal no-underline text-gray-100 bg-purple-500 hover:bg-purple-700">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>
