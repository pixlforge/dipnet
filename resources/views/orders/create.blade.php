@extends ('layouts.app')

@section ('title', 'Nouvelle commande')

@section ('content')
  @include ('layouts.partials._nav')
  @if ($order)
    <create-order :order="{{ $order }}"
                  :businesses="{{ $businesses }}"
                  :contacts="{{ $contacts }}"
                  :deliveries="{{ $deliveries }}"
                  :documents="{{ $documents }}"
                  :articles="{{ $articles }}"
                  :user="{{ auth()->user() }}"></create-order>
  @endif
@endsection