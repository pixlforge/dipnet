@extends ('layouts.app')

@section ('title', 'Commandes')

@section ('content')
  @include ('layouts.partials._nav')
  <orders user-role="{{ auth()->user()->role }}"></orders>
@endsection
