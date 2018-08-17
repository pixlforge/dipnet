@extends ('layouts.app')

@section ('title', 'Profile')

@section ('content')
  @include ('layouts.partials._nav')
  <profile :user="{{ auth()->user() }}"
           :orders="{{ $orders }}"
           :businesses="{{ $businesses }}"
           avatar="{{ auth()->user()->avatarPath() }}"
           random-avatar="{{ session('randomAvatar') }}"></profile>
  @include('layouts.partials._footer')
@endsection