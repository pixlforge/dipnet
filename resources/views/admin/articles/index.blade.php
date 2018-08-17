@extends('layouts.app')

@section('title', "Liste de tous les articles");

@section('content')
  @include ('layouts.partials._nav')
  <articles></articles>
  @include('layouts.partials._footer')
@endsection