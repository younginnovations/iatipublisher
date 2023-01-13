<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google tag (gtag.js) -->
  <script defer data-domain="[publisher.iatistandard.org](http://publisher.iatistandard.org/)" src="https://plausible.io/js/script.js"></script>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IATI Publisher') }}</title>
    <link rel="icon" type="image"
          href="https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png">

  {{-- Normal --}}
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.woff') }}" as="font" type="font/woff" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.eot') }}" as="font" type="font/eot" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.svg') }}" as="font" type="font/svg" crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.ttf') }}" as="font" type="font/ttf" crossorigin>

  {{-- Bold --}}
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.woff') }}" as="font" type="font/woff"
    crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.eot') }}" as="font" type="font/eot"
    crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.svg') }}" as="font" type="font/svg"
    crossorigin>
  <link rel="preload" href="{{ asset('fonts/Arial/arialbd-webfont.ttf') }}" as="font" type="font/ttf"
    crossorigin>


  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="icon"
    href="{{ URL::asset('https://prod-iati-website.azureedge.net/prod-iati-website/favicons/favicon-32x32.png') }}"
    type="image/x-icon" />

</head>

<body class="overflow-x-hidden">
<div id="app">
    @if (isSuperAdmin() && Auth::user()->organization)
        <admin-bar :name="{{ json_encode(Auth::user()->full_name, JSON_THROW_ON_ERROR) }}"
                   :organization-name="{{ json_encode(Auth::user()->organization?->publisher_name, JSON_THROW_ON_ERROR) }}">
        </admin-bar>
    @endif
    @if (isSuperAdmin())
        <loggedin-header :user="{{ Auth::user() }}"
                         :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray'), JSON_THROW_ON_ERROR) }}"
                        v-bind:super-admin="{{ isSuperAdminRoute()?1:0 }}"> </loggedin-header>
    @else
        <loggedin-header :user="{{ Auth::user() }}" :organization="{{ Auth::user()->organization }}"
                         :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray'), JSON_THROW_ON_ERROR) }}"
                        v-bind:super-admin="{{ isSuperAdminRoute()?1:0 }}"></loggedin-header>
    @endif
    <main>
        @yield('content')
        @stack('scripts')
    </main>
    <admin-footer v-bind:super-admin={{(int)isSuperAdmin()}}></admin-footer>
  </div>

  <script defer src="{{ mix('/manifest.js') }}"></script>
  <script defer src="{{ mix('/js/vendor.js') }}"></script>
  <script defer src="{{ mix('/js/app.js') }}"></script>
  <script defer src="{{ mix('/js/script.js') }}"></script>
  <script defer src="{{ mix('js/formbuilder.js') }}"></script>

</body>

</html>
