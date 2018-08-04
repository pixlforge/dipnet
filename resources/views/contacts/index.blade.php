@extends('layouts.app')

@section('title', "Liste de tous vos contacts")

@section('content')
  @include('layouts.partials._nav')
  <contacts
    :companies="{{ isset($companies) ? $companies : collect() }}"
    :user="{{ auth()->user() }}"></contacts>
@endsection
