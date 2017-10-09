@extends ('layouts.app')

@section ('title', 'Profile')

@section ('content')

    @include ('layouts.partials._nav')

    <app-profile :data-user="{{ $user }}"
                 :data-orders="{{ $orders }}"
                 :data-businesses="{{ $businesses }}"></app-profile>

@endsection