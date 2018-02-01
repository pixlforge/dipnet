@extends ('layouts.app')

@section ('title', 'Nouvelle commande')

@section ('content')

  @include ('layouts.partials._nav')

  @if ($order)
    <app-create-order :data-order="{{ $order }}"
                      :data-businesses="{{ $businesses }}"
                      :data-contacts="{{ $contacts }}"
                      :data-deliveries="{{ $deliveries }}"
                      :data-documents="{{ $documents }}"
                      :data-articles="{{ $articles }}">
    </app-create-order>
  @endif

@endsection