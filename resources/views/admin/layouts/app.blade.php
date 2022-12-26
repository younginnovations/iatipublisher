<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
    <style>html{display:none}</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IATI Publisher') }}</title>


    {{-- Normal --}}
    <link rel="preload" href="{{ asset('fonts/Arial/arial-webfont.woff') }}" as="font" type="font/woff"
        crossorigin>
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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" media="print" onload="this.media='all'">
     <link rel="icon"
        href="{{ asset('favicon.ico') }}"
        type="image/x-icon" />


</head>
<body  class="overflow-x-hidden" >
    <div id="app">
        @if (isSuperAdmin() && Auth::user()->organization)
            <admin-bar :name="{{ json_encode(Auth::user()->full_name, JSON_THROW_ON_ERROR) }}"
                :organization-name="{{ json_encode(Auth::user()->organization?->publisher_name, JSON_THROW_ON_ERROR) }}">
            </admin-bar>
        @endif
        @if (isSuperAdmin())
            <loggedin-header :user="{{ Auth::user() }}"
                has-admin-bar = "{{ isSuperAdmin() && Auth::user()->organization }}"
                :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray'), JSON_THROW_ON_ERROR) }}"
                v-bind:super-admin="{{ isSuperAdminRoute() ? 1 : 0 }}"> </loggedin-header>
        @else
            <loggedin-header
                :user="{{ Auth::user() }}" :organization="{{ Auth::user()->organization }}"
                :languages="{{ json_encode(getCodeListArray('Languages', 'ActivityArray'), JSON_THROW_ON_ERROR) }}"
                v-bind:super-admin="{{ isSuperAdminRoute() ? 1 : 0 }}"></loggedin-header>
        @endif
        <main>
            @yield('content')
            @stack('scripts')
        </main>
        <admin-footer v-bind:super-admin={{ (int) isSuperAdmin() }}></admin-footer>
    </div>
<script>
    window.globalLang = {
        'validation_lang': {!! json_encode(trans('validation'), JSON_THROW_ON_ERROR) !!},
        'web_lang': {!! json_encode(trans('web'), JSON_THROW_ON_ERROR) !!},
        'admin': {!! json_encode(trans('admin'), JSON_THROW_ON_ERROR) !!},
        'activities_lang': {!! json_encode(trans('activities'), JSON_THROW_ON_ERROR) !!},
        'activity_lang': {!! json_encode(trans('activity_detail'), JSON_THROW_ON_ERROR) !!},
        'activity_default_lang': {!! json_encode(trans('activity_default'), JSON_THROW_ON_ERROR) !!},
        'register_lang': {!! json_encode(trans('register'), JSON_THROW_ON_ERROR) !!},
        'settings_lang': {!! json_encode(trans('settings'), JSON_THROW_ON_ERROR) !!},
        'user_lang': {!! json_encode(trans('user'), JSON_THROW_ON_ERROR) !!},
        'elements_lang': {!! json_encode(trans('elements'), JSON_THROW_ON_ERROR) !!},
        'elements_common_lang': {!! json_encode(trans('elements_common'), JSON_THROW_ON_ERROR) !!},
        'org_lang': {!! json_encode(trans('organisation'), JSON_THROW_ON_ERROR) !!},
        'common_lang': {!! json_encode(trans('common'), JSON_THROW_ON_ERROR) !!},
        'button_lang': {!! json_encode(trans('buttons'), JSON_THROW_ON_ERROR) !!},
        'events_lang': {!! json_encode(trans('events'), JSON_THROW_ON_ERROR) !!},
        'misc_lang': {!! json_encode(trans('misc'), JSON_THROW_ON_ERROR) !!},
        'home': {!! json_encode(trans('home'), JSON_THROW_ON_ERROR) !!},
        'about': {!! json_encode(trans('about'), JSON_THROW_ON_ERROR) !!},
        'publishing_checklist': {!! json_encode(trans('publishing_checklist'), JSON_THROW_ON_ERROR) !!},
        'iati_standard': {!! json_encode(trans('iati_standard'), JSON_THROW_ON_ERROR) !!},
        'support': {!! json_encode(trans('support'), JSON_THROW_ON_ERROR) !!},
        'password_recovery': {!! json_encode(trans('password_recovery'), JSON_THROW_ON_ERROR) !!},
        'email_verification': {!! json_encode(trans('email_verification'), JSON_THROW_ON_ERROR) !!},
    };
</script>

    <script defer src="{{ mix('/manifest.js') }}"></script>
    <script defer src="{{ mix('/js/vendor.js') }}"></script>
    <script defer src="{{ mix('/js/app.js') }}"></script>
    <script defer src="{{ mix('/js/script.js') }}"></script>
    <script defer src="{{ mix('js/formbuilder.js') }}"></script>
    <!-- Start of iati Zendesk Widget script -->
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=f1df04e0-f01e-4ab5-9091-67b2fddd6e60"> </script>
    <script type="text/javascript">
        window.zESettings = {
            webWidget: {
                color: { theme: '#FFFFFF',
                launcherText: '#155366'},

                contactForm: {
                    attachments: true,
                }
            }
        };
    </script>
</body>

</html>
