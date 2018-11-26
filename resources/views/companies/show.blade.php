@extends('layouts.app')

@section('title', 'Profil de votre société "' . $company->name . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-company
    :company="{{ $company }}"
    :invitations="{{ $invitations }}"
    :businesses="{{ $businesses }}"
    :user="{{ auth()->user() }}">
  </show-company>
  @include('layouts.partials._footer')
@endsection