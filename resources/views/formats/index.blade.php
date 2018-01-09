@extends ('layouts.app')

@section ('title', 'Formats')

@section ('content')

    @include ('layouts.partials._nav')

    <app-formats :data-formats="{{ $formats }}"></app-formats>

@endsection
