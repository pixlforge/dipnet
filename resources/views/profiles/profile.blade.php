@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Profile')

@section ('content')

    <app-profile :user-data="{{ $user }}"></app-profile>

@endsection