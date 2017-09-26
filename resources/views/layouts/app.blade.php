<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    {{--Styles--}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @if (env('APP_NAME') === 'Dipnet')
        <link href="{{ mix('css/dip.css') }}" rel="stylesheet">
    @else
        <link href="{{ mix('css/multicop.css') }}" rel="stylesheet">
    @endif

    {{--Scripts--}}
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'appName' => env('APP_NAME')
        ]) !!};
    </script>
</head>
<body>

    <div id="app">
        @yield ('content')
        <flash message="{{ session('flash') }}"
               level="{{ session('level') }}">
        </flash>
    </div>

    {{--Scripts--}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
