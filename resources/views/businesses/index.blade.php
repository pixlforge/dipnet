@extends ('layouts.app')

@section ('title', 'Affaires')

@section ('content')
  @include ('layouts.partials._nav')
  <app-businesses :companies="{{ $companies }}"
                  :contacts="{{ $contacts }}"
                  :user="{{ auth()->user() }}"
                  :orders="{{ $orders }}"></app-businesses>
@endsection