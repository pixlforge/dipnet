<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  @include('layouts.partials._head')
</head>
<body id="body">
<div id="app">
  @yield ('content')
  <flash
    message="{{ session('flash') }}"
    level="{{ session('level') }}">
  </flash>
  <active-ticker
    :ticker="{{ $ticker ? $ticker : collect() }}"
    cookie="{{ Cookie::get('ticker') }}"/>
</div>
@include('layouts.partials._footer')
</body>
</html>