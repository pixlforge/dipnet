@extends('layouts.app')

@section('title', "Liste de toutes les livraisons");

@section('content')
  @include('layouts.partials._nav')
  <deliveries></deliveries>
@endsection