<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'IATI Publisher') }}</title>
  <link rel="icon" type="image"
    href="https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png">

  <!-- Scripts -->
  {{-- <script defer src="{{ mix('js/app.js') }}"></script> --}}
  <script defer src="{{ mix('js/script.js') }}"></script>
  <script defer src="{{ mix('js/formbuilder.js') }}"></script>

  <!-- Fonts -->
  {{-- <link href="http://fonts.cdnfonts.com/css/arial" rel="stylesheet"> --}}
  <link rel="preload" href="Arial" as="font" type="font/format" crossorigin>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="icon"
    href="{{ URL::asset('https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png') }}"
    type="image/x-icon" />

  {{-- select2 css --}}
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" /> --}}
  {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}

</head>

<style>

</style>

<body class="overflow-x-hidden">
  <div id="app">
    <loggedin-header :user="{{ Auth::user() }}" :organization="{{ Auth::user()->organization }}"
      :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray')) }}"></loggedin-header>

    <main>
      @yield('content')
      @stack('scripts')
    </main>
  </div>

  <script defer src="/custom/manifest.js"></script>
  <script defer src="/js/vendor.js"></script>
  <script defer src="/js/app.js"></script>
</body>

</html>
