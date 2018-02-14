@extends ('layouts.app')

@section ('title', 'Compléter les informations sur le contact')

@section ('content')

  <app-account-contact data-app-name="{{ config('app.name') }}"
                       :data-user="{{ auth()->user() }}">
  </app-account-contact>

@endsection