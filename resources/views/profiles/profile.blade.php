@extends ('layouts.app')

@section ('title', 'Profile')

@section ('content')

    @include ('layouts.partials._nav')

    <app-profile :user-data="{{ $user }}"></app-profile>

@endsection