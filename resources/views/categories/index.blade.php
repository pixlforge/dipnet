@extends ('layouts.app')

@section ('title', 'Catégories')

@section ('content')

    @include ('layouts.partials._nav')

    <app-categories :data="{{ $categories }}"></app-categories>

@endsection