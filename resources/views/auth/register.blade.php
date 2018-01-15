@extends ('layouts.app')

@section ('title', 'Création de compte')

@section ('content')

  <app-register token-data="{{ $token }}"
                data-app-name="{{ config('app.name') }}">
  </app-register>

@endsection
