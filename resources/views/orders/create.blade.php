@extends('layouts.app')

@section('title', 'Nouvelle commande')

@section('content')
  @include('layouts.partials._nav')
  @if ($order)
    <order-preparation :articles="{{ $articles }}"
                       :businesses="{{ $businesses }}"
                       :contacts="{{ $contacts }}"
                       :deliveries="{{ $deliveries }}"
                       :documents="{{ $documents }}"
                       :order="{{ $order }}"
                       :user="{{ auth()->user() }}">
    </order-preparation>
  @endif
  @include('layouts.partials._footer')
@endsection