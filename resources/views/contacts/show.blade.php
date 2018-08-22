@extends('layouts.app')

@section('title', 'Détails pour le contact "' . $contact->name . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-contact :contact="{{ $contact }}"
                :user="{{ auth()->user() }}"
                :companies="{{ $companies }}"></show-contact>
  @include('layouts.partials._footer')
@endsection