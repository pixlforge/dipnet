@extends('layouts.app')

@section('title', "Liste de tous les utilisateurs")

@section('content')
  @include ('layouts.partials._nav')
  <users :companies="{{ $companies }}"></users>
  @include('layouts.partials._footer')
@endsection