@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Contacts')

@section ('content')

    <app-contacts :data="{{ $contacts }}"></app-contacts>

@endsection
