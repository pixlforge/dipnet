@extends('layouts.app')

@section('title', "Liste de tous les documents")

@section('content')
  @include('layouts.partials._nav')
  <documents></documents>
@endsection