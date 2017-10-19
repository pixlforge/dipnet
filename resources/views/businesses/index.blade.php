@extends ('layouts.app')

@section ('title', 'Affaires')

@section ('content')

    @include ('layouts.partials._nav')

    <app-businesses :data-businesses="{{ $businesses }}"
                    :data-companies="{{ $companies }}"></app-businesses>

@endsection