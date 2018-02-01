@extends ('layouts.app')

@section ('title', 'Affaires')

@section ('content')

  @include ('layouts.partials._nav')

  <app-businesses :data-companies="{{ $companies }}"
                  :data-contacts="{{ $contacts }}"
                  :data-user="{{ auth()->user() }}">
  </app-businesses>

@endsection