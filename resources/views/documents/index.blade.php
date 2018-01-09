@extends ('layouts.app')

@section ('title', 'Documents')

@section ('content')

  @include ('layouts.partials._nav')

  <app-documents :data-documents="{{ $documents }}">
  </app-documents>

@endsection