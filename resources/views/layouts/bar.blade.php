<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @livewireStyles

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body id="bar" class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app" class="h-full flex flex-col">
        <div class="bg-purple-500 text-gray-100 py-1 px-12"></div>

        <div class="flex-1 px-4 md:px-12 pt-8 ">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @livewireScripts
    @stack('scripts')
</body>
</html>
