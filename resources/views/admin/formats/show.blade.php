@extends('layouts.app')

@section('title', 'Détails pour le format "' . $format->name . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-format :format="{{ $format }}"></show-format>
  @include('layouts.partials._footer')
@endsection