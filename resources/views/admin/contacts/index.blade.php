@extends('layouts.app')

@section('title', "Liste de tous les contacts")

@section('content')
  @include('layouts.partials._nav')
  <contacts
    :companies="{{ $companies }}"
    :user="{{ auth()->user() }}"></contacts>
  @include('layouts.partials._footer')
@endsection
