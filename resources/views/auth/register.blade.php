@extends ('layouts.app')

@section ('title', 'Création de compte')

@section ('content')

    <app-register token-data="{{ $token }}"></app-register>

@endsection
