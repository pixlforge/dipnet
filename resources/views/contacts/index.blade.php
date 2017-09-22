@extends ('layouts.app')

@section ('title', 'Contacts')

@section ('content')

    @include ('layouts.nav')

    <app-contacts :data="{{ $contacts }}"></app-contacts>

@endsection
