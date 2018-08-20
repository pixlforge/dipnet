@extends('layouts.app')

@section('title', "Détails de la commande " . $order->reference)

@section('content')
  @include('layouts.partials._nav')
  <order-preparation :articles="{{ $articles }}"
                     :businesses="{{ $businesses }}"
                     :contacts="{{ $contacts }}"
                     :deliveries="{{ $deliveries }}"
                     :documents="{{ $documents }}"
                     :formats="{{ $formats }}"
                     :order="{{ $order }}"
                     :user="{{ auth()->user() }}"
                     admin>
    </order-preparation>
  @include('layouts.partials._footer')
@endsection