@extends('layouts.app')

@section('title', "Détails du ticker")

@section('content')
  @include('layouts.partials._nav')
  <show-ticker :ticker="{{ $currentTicker }}"></show-ticker>
  @include('layouts.partials._footer')
@endsection