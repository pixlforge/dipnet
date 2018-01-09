@extends ('layouts.app')

@section ('title', 'Connexion à votre compte')

@section ('content')

  <app-login data-app-name="{{ config('app.name') }}">
  </app-login>

@endsection
