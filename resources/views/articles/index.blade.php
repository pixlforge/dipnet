@extends ('layouts.app')

@section ('title', 'Articles')

@section ('content')

    @include ('layouts.partials._nav')

    <app-articles :data-articles="{{ $articles }}"></app-articles>

@endsection