@extends ('layouts.app')

@section ('title', "Commande {$order->reference}")

@section ('content')

  @include ('layouts.partials._nav')

  <app-order-admin :data-order="{{ $order }}"
                   :data-deliveries="{{ $deliveries }}"
                   :data-articles="{{ $articles }}"
                   :data-documents="{{ $documents }}"
                   :data-businesses="{{ $businesses }}"
                   :data-contacts="{{ $contacts }}">
  </app-order-admin>

@endsection
