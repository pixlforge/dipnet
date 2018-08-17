@extends('layouts.app')

@section('title', "Liste de tous les formats")

@section('content')
  @include('layouts.partials._nav')
  <formats></formats>
  @include('layouts.partials._footer')
@endsection