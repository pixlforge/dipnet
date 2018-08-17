@extends('layouts.app')

@section('title', "Détails de la commande " . $order->reference)

@section('content')
  @include('layouts.partials._nav')
  @include('layouts.partials._footer')
@endsection