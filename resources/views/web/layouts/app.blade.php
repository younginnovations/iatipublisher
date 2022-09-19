<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image"
    href="https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png">

  <title>{{ config('app.name', 'IATI Publisher') }}</title>

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <script defer src="{{ mix('js/script.js') }}"></script>
  {{-- <script defer src="{{ mix('js/app.js') }}"></script> --}}

  <!-- Fonts -->
  {{-- Normal --}}
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.woff') }}" as="font" type="font/woff" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.eot') }}" as="font" type="font/eot" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.svg') }}" as="font" type="font/svg" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.ttf') }}" as="font" type="font/ttf" crossorigin>

  {{-- Bold --}}
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.woff') }}" as="font" type="font/woff"
    crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.eot') }}" as="font" type="font/eot" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.svg') }}" as="font" type="font/svg"
    crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.ttf') }}" as="font" type="font/ttf"
    crossorigin>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon"
    href="{{ URL::asset('https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png') }}"
    type="image/x-icon" />

</head>

<body class="font-sans bg-n-10 antialiased overflow-x-hidden">
  <div id="app">
    <web-header></web-header>
    @yield('content')
    <web-footer></web-footer>
  </div>

  <script defer src="/custom/manifest.js"></script>
  <script defer src="/js/vendor.js"></script>
  <script defer src="/js/app.js"></script>
</body>

</html>
