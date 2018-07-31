@extends('layouts.app')

@section('title', $company->name)

@section('content')
  @include('layouts.partials._nav')
  <show-company
    :company="{{ $company }}"
    :invitations="{{ $invitations }}"
    :businesses="{{ $businesses }}">
  </show-company>
@endsection