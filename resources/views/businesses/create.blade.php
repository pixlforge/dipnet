@extends ('layouts.app')

@section ('title', 'Ajouter une affaire par défaut')

@section ('content')

  <app-add-default-business :data-company="{{ $company }}"
                            :data-contacts="{{ $contacts }}">
  </app-add-default-business>

@endsection