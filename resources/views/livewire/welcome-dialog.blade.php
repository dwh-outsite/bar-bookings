<div>
    @if ($state !== 'inactive')
    <div id="background-overlay" class="absolute w-screen h-screen bg-black bg-opacity-75 z-50 top-0 left-0 flex items-center justify-center">
        <div id="welcome-dialog" class="bg-white rounded-lg overflow-hidden w-1/3 shadow-xl">
            <div class="bg-purple-500 text-gray-100 shadow px-6 py-4 text-lg flex justify-between items-center">
                <div>
                    @empty($name)
                        <strong>Register a guest</strong>
                    @else
                        <div>
                            <strong>Register</strong>
                            {{ $name }}
                        </div>
                    @endif
                </div>
                <button wire:click="close" class="ml-2 w-6 h-6 bg-white rounded-full font-bold text-purple-500 flex items-center justify-center text-sm">
                    ✕
                </button>
            </div>

            <div class="uppercase tracking-wide text-xs px-6 text-purple-400 bg-purple-100 py-3 font-semibold">
                {{ $states[$state] }}
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <p class="bg-red-200 text-red-800 p-2 rounded text-xs mb-6">
                        There is an issue with the information you entered.
                        Check all steps to find the issue.
                    </p>
                @endif

                @if ($state == 'name')

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

                @elseif ($state == 'health_check')

                    <label for="health_check" class="block bg-purple-200 rounded p-4 font-semibold flex-1 flex mb-6">
                        <input id="health_check" type="checkbox" class="form-checkbox h-8 w-8 mr-3 text-purple-500 @error('health_check') border-red-500 @enderror focus:outline-none" wire:model="health_check" value="true" required>
                        <div class="leading-tight">
                            Heb je klachten die bij corona horen zoals koorts, neusverkoudheid, keelpijn of hoesten?
                            <div class="text-sm mt-1 font-normal">
                                Do you have any corona-related health complains like a fever, a cold, a sore throat, or coughing?
                            </div>
                        </div>
                    </label>

                @elseif ($state == 'ggd_consent')

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
                                {{ __('Email Address') }}
                            </label>

                            <input id="email" type="email" class="form-input border-none w-full bg-gray-100 h-16  @error('email') border-red-500 @enderror" wire:model="email" value="{{ old('email') }}" placeholder="Email Address">

                            @error('email')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap mb-3">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Phone Number') }}
                            </label>

                            <input id="phone_number" type="phone_number" class="form-input border-none w-full bg-gray-100 h-16  @error('phone_number') border-red-500 @enderror" wire:model="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">

                            @error('phone_number')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    @endif
                @endif

                <div class="flex justify-between">
                    <div>
                        @if (array_search($state, array_keys($states)) > 0)
                            <button wire:click="back" class="font-bold py-3 px-6 rounded border-2 border-purple-300 text-purple-300 hover:bg-purple-300 hover:text-white">
                                &laquo; {{ __('Back') }}
                            </button>
                        @endif
                    </div>
                    <div>
                        @if (array_search($state, array_keys($states)) < (count($states) - 1))
                            <button wire:click="next" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
                                {{ __('Next') }} &raquo;
                            </button>
                        @else
                            <button wire:click="register" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
                                Register
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
