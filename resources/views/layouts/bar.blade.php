<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-purple-500 text-gray-100 shadow py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <a href="{{ route('admin.home') }}" class="text-lg font-semibold no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
            </div>
        </nav>

        <div class="flex">
            <div class="w-3/5">
                <div class="pl-12 pt-8 pr-6">
                    @yield('content')
                </div>
            </div>
            <div class="w-2/5 border-l-8 border-purple-500 bg-purple-100">
                <div class="pl-6 pt-8 pr-12">
                    @include('bar.health-check')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
