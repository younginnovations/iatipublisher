<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'IATI Publisher') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image" href="https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script defer src="{{ asset('js/script.js') }}"></script>

  <!-- Fonts -->
  {{-- <link href="http://fonts.cdnfonts.com/css/arial" rel="stylesheet"> --}}

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="icon"
    href="{{ URL::asset('https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png') }}"
    type="image/x-icon" />

</head>

<body>
  <div id="app">
    <loggedin-header :user="{{ Auth::user() }}" :organization="{{ Auth::user()->organization }}" :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray'))}}"></loggedin-header>

    <main>
      @yield('content')
    </main>
  </div>
</body>

</html>
