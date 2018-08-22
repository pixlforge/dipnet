@extends('layouts.app')

@section('title', 'Compléter les informations sur le contact')

@section('content')
  <account-contact :user="{{ auth()->user() }}"></account-contact>
@endsection