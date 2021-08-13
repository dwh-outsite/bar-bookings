<div>
    @if ($state == 'inactive')
        <div class="text-center h-full flex items-center justify-center">
            <div>
                <div class="mb-4">
                    Welkom, <strong>{{ $booking->name }}</strong>!
                </div>

                @if ($booking->ggd_consent)
                    <div class="mb-4">
                        Je gegevens zijn succesvol geregistreerd!
                    </div>
                @endif

                <div class="mb-8">
                    Fijne avond!
                </div>

                <div class="text-gray-700 text-sm leading-tight mt-1 mb-8" >
                    <div class="mb-2">
                        Welcome, <strong>{{ $booking->name }}</strong>!
                    </div>
                    @if ($booking->ggd_consent)
                        <div class="mb-2">
                            Your contact details have been registered successfully.
                        </div>
                    @endif
                    <div class="mb-2">
                        Enjoy your night!
                    </div>
                </div>

                <div class="my-4 text-gray-600 text-sm leading-tight">
                    <a wire:click="openForm" class="underline">Voorkeuren wijzigen / Change preferences</a>
                </div>
            </div>
        </div>
    @elseif ($state == 'form')
        <livewire:visitor-details-form :booking="$booking" />
    @endif
</div>
