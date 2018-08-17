@extends('layouts.app')

@section('title', "Liste de toutes les sociétés")

@section('content')
  @include('layouts.partials._nav')
  <companies></companies>
  @include('layouts.partials._footer')
@endsection