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

                    @if ($event->availableSeats() <= 0)
                        <div class="bg-red-500 text-white rounded p-4 mb-4">
                            <span class="font-bold">Please note:</span>
                            this event is full! If you have a good reason to another guest, this is still possible.
                            Otherwise, ask the guest to come back another time.
                        </div>
                    @endif

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

                            @if ($event->availableTwoSeats() > 0)
                                <label for="twoseat-true" class="block bg-purple-200 rounded p-4 font-semibold flex-1 flex ml-2">
                                    <input id="twoseat-true" type="radio" class="form-radio h-8 w-8 mr-2 text-purple-500 @error('twoseat') border-red-500 @enderror" wire:model="twoseat" value="true" required>
                                    <div>
                                        Two-person Seat
                                        <div class="text-sm mt-1 font-normal">Within 1.5 metres</div>
                                    </div>
                                </label>
                            @endif
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

                @elseif ($state == 'contact_details')
                    <div class="bg-red-500 text-white rounded p-4 mb-4">
                        <span class="font-bold">Please note:</span>
                        <em>every</em> guest <em>has to</em> scan the QR code
                        <div class="text-xs mt-1">(or use any of the alternatives described below)</div>
                    </div>

                    The QR code for the registration of personal details of the visitor is now being shown on the tablet.
                    If the visitor cannot scan a QR code, they can visit <strong>dwhdelft.nl/welcome</strong> and enter code <strong>{{ $booking->visitor_code }}</strong> (also shown on the tablet).<br />
                    <br />
                    Every guest has a unique (QR) code.<br />
                    <br />
                    Alternatively, you can show the form for entering personal details on the tablet by pressing the button below.
                    Only use this if the guest cannot use their phone since it puts you in charge of registering their tables.

                    <div class="my-4 flex space-x-4">
                        <button wire:click="showVisitorCodeOnTablet" class="w-2/3 font-bold py-3 px-6 rounded border-2 border-purple-500 text-purple-500 hover:bg-purple-500 hover:text-white">
                            Show QR code on tablet
                            <div class="text-xs font-normal">Active by default</div>
                        </button>
                        <button wire:click="showVisitorDetailsFormOnTablet" class="w-1/3 font-bold py-3 px-6 rounded border-2 border-purple-200 text-purple-400 hover:bg-purple-500 hover:text-white">
                            Show form on tablet
                        </button>
                    </div>

                    As soon as the guest has scanned their code, they can take a seat and fill out the form at their table.

                    <h2 class="font-semibold text-purple-500 mt-6 mb-2 tracking-wide uppercase border-b border-purple-500 pb-2">
                        Current contact details
                    </h2>
                    <div class="text-sm text-gray-700">(updated automatically)</div>

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
                @endif

                <div class="flex justify-between">
                    @if ($state != 'contact_details')
                        <div>
                            @if (array_search($state, array_keys($states)) > 0)
                                <button wire:click="back" class="font-bold py-3 px-6 rounded border-2 border-purple-300 text-purple-300 hover:bg-purple-300 hover:text-white">
                                    &laquo; {{ __('Back') }}
                                </button>
                            @endif
                        </div>
                        <div>
                            @if (array_search($state, array_keys($states)) < (count($states) - 2))
                                <button wire:click="next" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
                                    {{ __('Next') }} &raquo;
                                </button>
                            @else
                                <button wire:click="register" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
                                    Register
                                </button>
                            @endif
                        </div>
                    @else
                        <div></div>
                        <button wire:click="close" class="font-bold py-3 px-6 rounded text-gray-100 bg-purple-500 hover:bg-purple-700">
                            Close
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
