@include('layouts.nav')

@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col intro d-flex justify-content-center align-items-center">
                @if (env('APP_NAME') == 'Dipnet')
                    <div class="col-xs-12 col-md-4">
                        <img src="{{ asset('img/logos/dip-logo-lg.png') }}" alt="Dip logo" class="img-fluid">
                    </div>
                @endif
                @if (env('APP_NAME') == 'Multicop')
                    <div class="col-xs-12 col-md-8">
                        <img src="{{ asset('img/logos/multicop-logo-lg.png') }}" alt="Multicop logo" class="img-fluid">
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection