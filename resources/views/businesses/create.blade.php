@extends ('layouts.app')

@section ('title', 'Ajouter une affaire par défaut')

@section ('content')
  <add-default-business :company="{{ $company }}"
                        :contacts="{{ $contacts }}"></add-default-business>
@endsection