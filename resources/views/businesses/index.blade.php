@extends ('layouts.app')

@section ('title', 'Affaires')

@section ('content')

    @include ('layouts.partials._nav')

    <app-businesses :businesses-data="{{ $businesses }}"
                    :companies-data="{{ $companies }}"></app-businesses>

@endsection