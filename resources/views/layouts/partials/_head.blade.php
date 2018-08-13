<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

@include('layouts.partials._favicon')

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