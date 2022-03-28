<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>IATI Publisher</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script defer src="{{ asset('js/script.js') }}"></script>
  <script defer src="{{ asset('js/app.js') }}"></script>

</head>

<body class="font-sans bg-n-10 antialiased overflow-x-hidden">
  <div id="app">
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
  </div>
</body>

</html>
