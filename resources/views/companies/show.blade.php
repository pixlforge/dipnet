@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Détails pour la société ' . auth()->user()->company->name)

@section ('content')

    <app-show-company :data="{{ $company }}"></app-show-company>

@endsection