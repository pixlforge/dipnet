@extends ('layouts.app')

@section ('title', 'Commandes')

@section ('content')
  @include ('layouts.partials._nav')
  <app-orders user-role="{{ auth()->user()->role }}"></app-orders>

@endsection
