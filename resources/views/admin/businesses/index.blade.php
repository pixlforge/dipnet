@extends('layouts.app')

@section('title', "Liste de toutes les affaires")

@section('content')
  @include('layouts.partials._nav')
  <businesses
    :companies="{{ $companies }}"
    :contacts="{{ $contacts }}"
    :user="{{ auth()->user() }}"
    :users="{{ $users }}"
    :orders="{{ $orders }}">
  </businesses>
  @include('layouts.partials._footer')
@endsection