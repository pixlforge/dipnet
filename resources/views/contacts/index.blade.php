@include('layouts.nav')

@extends('layouts.app')

@section('content')

    <contacts :data="{{ $contacts }}"></contacts>

@endsection
