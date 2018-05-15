@extends ('layouts.app')

@section ('title', 'Détails pour la société ' . auth()->user()->company->name)

@section ('content')
  @include ('layouts.partials._nav')
  <app-show-company :company="{{ $company }}"
                    :invitations="{{ $invitations }}"
                    :businesses="{{ $businesses }}"></app-show-company>

@endsection