@extends ('layouts.app')

@section ('title', 'Liste de tous les tickers')

@section ('content')
  @include ('layouts.partials._nav')
  <tickers></tickers>
  @include('layouts.partials._footer')
@endsection