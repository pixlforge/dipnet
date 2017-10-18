@extends ('layouts.app')

@section ('title', 'Sociétés')

@section ('content')

    @include ('layouts.partials._nav')

    <app-companies :data-companies="{{ $companies }}"></app-companies>

@endsection