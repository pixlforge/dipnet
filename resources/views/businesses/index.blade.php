@extends('layouts.app')

@section('title', 'Affaires')

@section('content')
  @include('layouts.partials._nav')
  <businesses
    :companies="{{ $companies }}"
    :contacts="{{ $contacts }}"
    :user="{{ auth()->user() }}"
    :orders="{{ $orders }}">
  </businesses>
@endsection