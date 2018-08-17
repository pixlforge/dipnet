@extends('layouts.app')

@section('title', "Définition d'une affaire par défaut pour votre société")

@section('content')
<add-default-business
  :company="{{ $company }}"
  :businesses="{{ $businesses }}"></add-default-business>
  @include('layouts.partials._footer')
@endsection