<div class="w-screen h-screen absolute top-0 left-0 flex items-center justify-center">
    @if ($state == 'details_form')
        <div class="w-2/3">
            <livewire:visitor-details-form :booking="$booking" />
        </div>
    @elseif ($state == 'visitor_code')
        <div class="bg-white rounded-lg overflow-hidden w-5/6 shadow-xl p-6 flex items-center">
            <div class="mr-6">
                <div id="qrcode"></div>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="mb-4">
                    <h2 class="text-purple-500 text-4xl font-bold leading-tight mb-2">Scan de QR code om je gegevens te registreren</h2>
                    <h2 class="text-purple-400 text-2xl font-semibold leading-tight">Scan the QR code to register your personal details</h2>
                </div>

                <div class="flex items-center bg-purple-100 p-3 rounded">
                    <div class="flex-1">
                        <div class="mb-2">
                            Geen QR code scanner? Ga naar <strong>dwhdelft.nl/welkom</strong> en vul de code in
                        </div>
                        <div>
                            No QR code scanner? Go to <strong>dwhdelft.nl/welcome</strong> and enter the code
                        </div>
                    </div>
                    <div class="text-purple-500 text-4xl font-bold text-center mr-4">
                        {{ $booking->visitor_code }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" class="w-2/5" viewBox="0 0 241 116.5" xml:space="preserve"><path d="M230.2 77.04h-2.32V49.76c0-10.67-10.2-19.18-22.85-19.3-6.63.05-12.06.89-18.25 4.8V13.98c.14-4-2.82-6.52-6.55-6.52l-11.37-.01c-3.67.06-6.63 2.85-6.63 6.3 0 3.46 3.16 6.27 6.84 6.32h4.7V77.1h-2.36a6.58 6.58 0 00-6.64 6.46c0 3.54 3.1 6.4 6.78 6.45h17.53c3.73 0 6.75-2.89 6.75-6.45s-2.96-6.47-6.69-6.47l-2.42.01V52.4c5.03-5.34 10.62-9.18 15.8-9.18 6.07 0 12.05 1.5 12.13 9.59v24.21h-2.27c-3.7.05-6.67 2.92-6.67 6.46 0 3.53 3.03 6.41 6.71 6.46h17.6c3.73 0 6.75-2.9 6.75-6.46a6.43 6.43 0 00-6.57-6.44zM77.68 77.37h-4.55V20.53h4.64A6.65 6.65 0 0084.52 14c0-3.62-3.17-6.55-6.9-6.55l-10.97-.01c-3.67.06-6.54 2.7-6.54 6.29l-.01 23.25c-5.46-3.87-12.85-6.16-20.18-6.16-19 0-32.2 15.65-32.2 31.1 0 17.18 12.56 30.65 32.74 30.56 7.42-.04 14.26-1.53 19.75-5.48 1.06 2.01 3.15 3.15 5.6 3.28h11.86c3.73 0 6.76-2.73 6.76-6.35a6.65 6.65 0 00-6.75-6.55zm-36.85 2.19c-13.46.08-20.19-7.2-20-18.01.16-9.94 9.18-17.55 19.45-18 10.74-.48 20 8.87 20 18.82 0 9.94-8.7 17.11-19.45 17.19zM89.48 32.26h-.01M89.48 32.26"/><path d="M154.6 32.37l-16.39.01c-3.68.06-6.8 2.97-6.63 6.55.17 3.81 2.55 6.43 6.6 6.52l2.76-.02-5.16 21.51-7.53-20.11c-1.09-3.22-3.4-5.45-6.5-5.45-3.24 0-5.18 1.55-6.58 5.85l-7.4 19.75-5.19-21.62h2.81c3.73 0 6.87-2.93 6.87-6.55 0-3.62-3.37-6.56-7.1-6.56l-15.68.01a6.65 6.65 0 00-6.64 6.55 6.65 6.65 0 006.64 6.55l9.3 38.03c1.04 4.8 3.78 7.64 7.97 7.64a8.29 8.29 0 007.7-5.14l7.43-20.16 7.39 19.74c1.44 3.33 4.23 5.55 7.67 5.38 4.5-.23 7.03-2.73 8.2-7.65l9.1-37.73a6.66 6.66 0 006.75-6.54c0-3.62-2.66-6.56-6.39-6.56z"/><ellipse fill="#66328F" cx="206.42" cy="14.17" rx="6.82" ry="6.73"/><path fill="#2AAAE2" d="M152.95 14.17a6.77 6.77 0 01-6.82 6.72c-3.76 0-6.82-3-6.82-6.72a6.78 6.78 0 016.82-6.74 6.78 6.78 0 016.82 6.74z"/><ellipse fill="#3BB34A" cx="122.49" cy="14.17" rx="6.82" ry="6.73"/><path fill="#F6EC27" d="M106.2 14.17a6.77 6.77 0 01-6.8 6.73 6.78 6.78 0 01-6.83-6.73 6.78 6.78 0 016.82-6.73 6.78 6.78 0 016.82 6.73z"/><path fill="#F04E28" d="M50.74 14.17a6.78 6.78 0 01-6.82 6.73 6.77 6.77 0 01-6.82-6.73 6.78 6.78 0 016.82-6.73 6.78 6.78 0 016.82 6.73z"/></svg>
    @endif
</div>

@push('scripts')
    <script src="/lib/qrcode.min.js"></script>
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', event => {
            Echo.private('tablet')
                .listen('ShowDetailsFormOnTablet', data => {
                    @this.call('showDetailsForm', data.booking)
                })
                .listen('ShowVisitorCodeOnTablet', data => {
                    @this.call('showVisitorCode', data.booking)
                })
                .listen('DeactivateTablet', data => {
                    @this.call('close')
                });

            @this.on('tablet-show-visitor-code', visitorCode => {
                new QRCode(
                    document.getElementById("qrcode"),
                    "{{ route('visitor') }}?visitor_code=" + visitorCode
                );
            });
        });
    </script>
@endpush
