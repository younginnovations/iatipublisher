<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
     <style>
         html{display:none}
     </style>
    <!-- Google tag (gtag.js) -->
    @production
    <script defer data-domain="publisher.iatistandard.org" src=https://plausible.io/js/script.js></script>
    @endproduction

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', trans('web.home_page.iati_publisher')) }}</title>

  <!-- Fonts -->
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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- styles -->
    <link rel="stylesheet" href="{{ mix('css/webportal-app.css') }}" media="print" onload="this.media='all'">

    <link rel="icon"
        href="{{ asset('favicon.ico') }}"
        type="image/x-icon" />

</head>

<body  class="font-sans bg-n-10 antialiased overflow-x-hidden">
    <div id="app">
        <web-header title='@yield('title', 'IATI PUBLISHER')' auth='{{ (bool) Auth::user() }}'
            :super-admin='{{ Auth::check() ? (int) isSuperAdmin() : 0 }}'></web-header>
        <main  >@yield('content')</main>
        @if (Auth::user())
            <admin-footer :super-admin='{{ Auth::check() ? (int) isSuperAdmin() : 0 }}'></admin-footer>
        @else
            <web-footer></web-footer>
        @endif
    </div>

    <script defer src="{{ mix('/manifest.js') }}"></script>
    <script defer src="{{ mix('/js/vendor.js') }}"></script>
    <script defer src="{{ mix('/js/app.js') }}"></script>
    <script defer src="{{ mix('js/webportal-script.js') }}"></script>

  <script>
      window.globalLang = {
          'web_lang': {!! json_encode(trans('web'), JSON_THROW_ON_ERROR) !!},
          'home': {!! json_encode(trans('home'), JSON_THROW_ON_ERROR) !!},
          'about': {!! json_encode(trans('about'), JSON_THROW_ON_ERROR) !!},
          'publishing_checklist': {!! json_encode(trans('publishing_checklist'), JSON_THROW_ON_ERROR) !!},
          'iati_standard': {!! json_encode(trans('iati_standard'), JSON_THROW_ON_ERROR) !!},
          'support': {!! json_encode(trans('support'), JSON_THROW_ON_ERROR) !!},
          'password_recovery': {!! json_encode(trans('password_recovery'), JSON_THROW_ON_ERROR) !!},
          'email_verification': {!! json_encode(trans('email_verification'), JSON_THROW_ON_ERROR) !!},
          'register_lang': {!! json_encode(trans('register'), JSON_THROW_ON_ERROR) !!},
          'elements_common_lang': {!! json_encode(trans('elements_common'), JSON_THROW_ON_ERROR) !!},
          'common_lang': {!! json_encode(trans('common'), JSON_THROW_ON_ERROR) !!},
          'button_lang': {!! json_encode(trans('buttons'), JSON_THROW_ON_ERROR) !!},
          'user_lang': {!! json_encode(trans('user'), JSON_THROW_ON_ERROR) !!},
          'validation_lang': {!! json_encode(trans('validation'), JSON_THROW_ON_ERROR) !!},
          'admin': {!! json_encode(trans('admin'), JSON_THROW_ON_ERROR) !!},
          'activities_lang': {!! json_encode(trans('activities'), JSON_THROW_ON_ERROR) !!},
          'activity_lang': {!! json_encode(trans('activity_detail'), JSON_THROW_ON_ERROR) !!},
          'activity_default_lang': {!! json_encode(trans('activity_default'), JSON_THROW_ON_ERROR) !!},
          'settings_lang': {!! json_encode(trans('settings'), JSON_THROW_ON_ERROR) !!},
          'elements_lang': {!! json_encode(trans('elements'), JSON_THROW_ON_ERROR) !!},
          'org_lang': {!! json_encode(trans('organisation'), JSON_THROW_ON_ERROR) !!},
          'events_lang': {!! json_encode(trans('events'), JSON_THROW_ON_ERROR) !!},
          'misc_lang': {!! json_encode(trans('misc'), JSON_THROW_ON_ERROR) !!},
          'element_labels_lang': {!! json_encode(trans('element_labels'), JSON_THROW_ON_ERROR) !!},
      };
  </script>
</body>

</html>
