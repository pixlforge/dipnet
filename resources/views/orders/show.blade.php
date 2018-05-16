@extends ('layouts.app')

@section ('title', "Commande {$order->reference}")

@section ('content')
  @include ('layouts.partials._nav')
  <order-admin :order="{{ $order }}"
               :deliveries="{{ $deliveries }}"
               :articles="{{ $articles }}"
               :documents="{{ $documents }}"
               :businesses="{{ $businesses }}"
               :contacts="{{ $contacts }}"
               :formats="{{ $formats }}"></order-admin>
@endsection
