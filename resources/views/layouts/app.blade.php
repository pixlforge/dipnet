<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  {{--CSRF Token--}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }} | @yield ('title')</title>

  {{--Styles--}}
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  @routes

  {{--Scripts--}}
  <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'appName' => config('app.name')
        ]) !!};
  </script>
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body id="body">
<div id="app">
  @yield ('content')
  <flash message="{{ session('flash') }}"
         level="{{ session('level') }}">
  </flash>
</div>
</body>
</html>