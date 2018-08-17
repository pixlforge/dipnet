@extends('layouts.app')

@section('title', 'Bulletin de livraison référence ' . $delivery->reference)

@section('content')
  @include('layouts.partials._nav')
  <div class="receipt__header">
    @if (config('app.name') === 'Dipnet')
      <img class="receipt__logo"
           src="{{ asset('/img/logos/header-dip.gif') }}"
           alt="En-tête Dip">
    @elseif (config('app.name') === 'Multicop')
      <img class="receipt__logo"
           src="{{ asset('/img/logos/header-multicop.png') }}"
           alt="En-tête Multicop">
    @endif
      <h1 class="receipt__title">Bulletin de livraison
        <small>(ref. {{ $delivery->reference }})</small>
      </h1>
  </div>

  <div class="receipt__content">
    <div class="receipt__container">

      {{-- First row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Date de la commande</h2>
          <p class="receipt__item-content">
            {{ $order->updated_at->formatLocalized('%e %B %Y - %H:%M') }}
          </p>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commande n°</h2>
          <p class="receipt__item-content">
            {{ $order->reference }}
          </p>
        </div>
      </div>

      {{-- Second row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commandé par</h2>
          <ul class="receipt__item-list">
            <li>{{ optional($company)->name }}</li>
            <li>{{ optional($company)->description }}</li>
            <li>{{ optional($company)->status }}</li>
            <br>
            <li>{{ optional($user)->username }}</li>
            <li>{{ optional($user)->email }}</li>
          </ul>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Livraison chez</h2>
          <ul class="receipt__item-list">
            <li>{{ ucfirst($delivery->contact->name) }}</li>
            <li>{{ $delivery->contact->address_line1 }}</li>
            <li>{{ $delivery->contact->address_line2 }}</li>
            <li>{{ $delivery->contact->zip }} {{ $delivery->contact->city }}</li>
            <li>{{ $delivery->contact->phone_number }}</li>
            <li>{{ $delivery->contact->fax }}</li>
            <li>{{ $delivery->contact->email }}</li>
          </ul>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Facturation à</h2>
          <ul class="receipt__item-list">
            <li>{{ ucfirst($order->contact->name) }}</li>
            <li>{{ $order->contact->address_line1 }}</li>
            <li>{{ $order->contact->address_line2 }}</li>
            <li>{{ $order->contact->zip }} {{ $order->contact->city }}</li>
            <li>{{ $order->contact->phone_number }}</li>
            <li>{{ $order->contact->fax }}</li>
            <li>{{ $order->contact->email }}</li>
          </ul>
        </div>
      </div>

      {{-- Third row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Affaire</h2>
          <p class="receipt__item-content">
            {{ $order->business->name }}
          </p>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commande prise en charge par</h2>
          <p class="receipt__item-content">
            {{ optional($order->managedBy)->username }}
          </p>
        </div>
      </div>

      {{-- Fourth row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commentaire</h2>
          <p class="receipt__item-content">
            @if ($delivery->note)
              {{ $delivery->note }}
            @else
              Aucun commentaire.
            @endif
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="receipt__content">
    <div class="receipt__container">
      <table class="receipt__table">
        <tr class="receipt__table-header">
          <th>Nom de fichier</th>
          <th>Impression</th>
          <th>Finition</th>
          <th>Options</th>
          <th>Quantité</th>
          <th>Largeur</th>
          <th>Hauteur</th>
          <th>Nb. Orig.</th>
        </tr>
        @foreach($documents as $document)
          <tr>
            <td>{{ $document->filename }}</td>
            <td>{{ $document->article->description }}</td>
            <td>{{ ucfirst($document->finish) }}</td>
            <td>
              <ol>
                @foreach($document->articles as $option)
                  <li>{{ $option->description }}</li>
                @endforeach
              </ol>
            </td>
            <td>{{ $document->quantity }}</td>
            <td>{{ $document->width }}</td>
            <td>{{ $document->height }}</td>
            <td>{{ $document->nb_orig }}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
  @include('layouts.partials._footer')
@endsection