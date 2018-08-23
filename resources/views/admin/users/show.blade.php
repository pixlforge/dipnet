@extends('layouts.app')

@section('title', 'Détails de l\'utilisateur "' . $user->username . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-user :user="{{ $user }}"
             :companies="{{ $companies }}"
             random-avatar={{ session('randomAvatar') }}></show-user>
  @include('layouts.partials._footer')
@endsection