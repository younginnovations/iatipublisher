<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script defer src="{{ asset('js/script.js') }}"></script>

</head>

<body class="font-sans bg-background antialiased">
  <div id="app">
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
  </div>
</body>

</html>
