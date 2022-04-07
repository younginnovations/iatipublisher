<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IATI Publisher') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script defer src="{{ asset('js/script.js') }}"></script>

    <!-- Fonts -->
    <link href="http://fonts.cdnfonts.com/css/arial" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <loggedin-header></loggedin-header>

        <main class="py-4 min-h-screen bg-paper">
            @yield('content')
        </main>
    </div>
</body>
</html>
