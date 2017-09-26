@extends ('layouts.app')

@section ('title', 'Contacts')

@section ('content')

    @include ('layouts.partials._nav')

    <app-contacts :data="{{ $contacts }}"></app-contacts>

@endsection
