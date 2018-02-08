@extends ('layouts.app')

@section ('title', 'Affaire ' . $business->name)

@section ('content')

  @include ('layouts.partials._nav')

  <app-show-business :data-business="{{ $business }}"
                     :data-contacts="{{ $contacts }}"
                     :data-user="{{ auth()->user() }}"
                     :data-orders="{{ $orders }}">
  </app-show-business>

@endsection