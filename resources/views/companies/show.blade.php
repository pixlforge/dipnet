@extends ('layouts.app')

@section ('title', 'Détails pour la société ' . auth()->user()->company->name)

@section ('content')

    @include ('layouts.nav')

    <app-show-company :data="{{ $company }}"></app-show-company>

@endsection