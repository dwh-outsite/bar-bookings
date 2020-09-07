<div>
    @if ($state == 'inactive')
        <div class="text-center h-full flex items-center justify-center">
            <div>
                <div class="mb-4">
                    Welkom, <strong>{{ $booking->name }}</strong>!
                </div>

                @if ($booking->ggd_consent)
                    <livewire:visitor-table-registration :booking="$booking" />
                @else
                    <div class="text-gray-600 text-sm leading-tight">
                        Je hebt geen toestemming gegeven om je gegevens te delen met de GGD, je kunt daarom geen tafel registreren.
                    </div>
                @endif

                <div class="my-4 text-gray-600 text-sm leading-tight">
                    <a wire:click="openForm" class="underline">Voorkeuren wijzigen.</a>
                </div>
            </div>
        </div>
    @elseif ($state == 'form')
        <livewire:visitor-details-form :booking="$booking" />
    @endif
</div>
