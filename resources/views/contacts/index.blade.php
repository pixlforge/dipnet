@extends ('layouts.app')

@section ('title', 'Contacts')

@section ('content')
  @include ('layouts.partials._nav')
  <contacts :companies="{{ $companies }}"
            :user="{{ auth()->user() }}"></contacts>
@endsection
