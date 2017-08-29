@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Contacts')

@section ('content')

    <contacts :data="{{ $contacts }}"></contacts>

@endsection
