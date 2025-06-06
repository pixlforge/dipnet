@extends('layouts.app')

@section('title', 'Bulletin de livraison référence ' . $delivery->reference)

@section('content')
  @include('layouts.partials._nav')
  <div class="receipt__header">
    @if (config('app.name') === 'Dipnet')
      <img class="receipt__logo"
           src="{{ asset('/img/logos/header-dip.gif') }}"
           alt="En-tête Dip">
    @elseif (config('app.name') === 'Multiprint')
      <img class="receipt__logo"
           src="{{ asset('/img/logos/header-multicop.png') }}"
           alt="En-tête Multiprint">
    @endif
      <h1 class="receipt__title">Bulletin de livraison</h1>
      <p class="text-center">
        <small>(ref. {{ $delivery->reference }})</small>
      </p>
  </div>

  <div class="receipt__content">
    <div class="receipt__container">

      {{-- First row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Date de la commande</h2>
          <p>
            {{ $delivery->order->updated_at->formatLocalized('%e %B %Y - %H:%M') }}
          </p>
        </div>

        <div class="receipt__item">
          <h2 class="receipt__item-title">Affaire</h2>
          <p>
            {{ $business->name }}
          </p>
        </div>

        <div class="receipt__item">
          <h2 class="receipt__item-title">Commande n°</h2>
          <p>
            {{ $delivery->order->reference }}
          </p>
        </div>
      </div>

      {{-- Second row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commandé par</h2>
          <ul class="receipt__item-list">

            @if ($delivery->order->company)
              <li>{{ $delivery->order->company->name }}</li>
              <li>{{ $delivery->order->company->description }}</li>
              <br>
            @endif

            <li>{{ $delivery->order->user->username }}</li>
            <li>{{ $delivery->order->user->email }}</li>
          </ul>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Livraison chez</h2>
          <ul class="receipt__item-list">
            @if ($delivery->contact)

              <li>{{ $delivery->contact->company_name ? ucfirst($delivery->contact->company_name) : '' }}</li>
              <li>{{ ucfirst($delivery->contact->first_name) }}</li>
              <li>{{ $delivery->contact->last_name ? ucfirst($delivery->contact->last_name) : '' }}</li>

              <li>{{ $delivery->contact->address_line1 }}</li>
              <li>{{ $delivery->contact->address_line2 }}</li>
              <li>{{ $delivery->contact->zip }} {{ $delivery->contact->city }}</li>
              <li>{{ $delivery->contact->phone_number }}</li>
              <li>{{ $delivery->contact->fax }}</li>
              <li>{{ $delivery->contact->email }}</li>
            @else
              <li>À récupérer sur place</li>
            @endif
          </ul>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Facturation à</h2>
          <ul class="receipt__item-list">

            <li>{{ $delivery->order->contact->company_name ? ucfirst($delivery->order->contact->company_name) : '' }}</li>
            <li>{{ ucfirst($delivery->order->contact->first_name) }}</li>
            <li>{{ $delivery->order->contact->last_name ? ucfirst($delivery->order->contact->last_name) : '' }}</li>

            <li>{{ $delivery->order->contact->address_line1 }}</li>
            <li>{{ $delivery->order->contact->address_line2 }}</li>
            <li>{{ $delivery->order->contact->zip }} {{ $delivery->order->contact->city }}</li>
            <li>{{ $delivery->order->contact->phone_number }}</li>
            <li>{{ $delivery->order->contact->fax }}</li>
            <li>{{ $delivery->order->contact->email }}</li>
          </ul>
        </div>
      </div>

      {{-- Third row --}}
      <div class="receipt__row">
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commentaire</h2>
          <p>
            @if ($delivery->note)
              {{ $delivery->note }}
            @else
              Aucun commentaire.
            @endif
          </p>
        </div>
        <div class="receipt__item">
          <h2 class="receipt__item-title">Commande prise en charge par</h2>
          @if ($delivery->order->managedBy)
            <p>
              {{ $delivery->order->managedBy->username }}
              ({{ $delivery->order->managedBy->email }})
            </p>
          @else
            <p>Cette livraison n'a pas encore été prise en charge.</p>
          @endif
        </div>
      </div>

    </div>
  </div>

  <div class="receipt__content">
    <div class="receipt__container">
      <table class="receipt__table">
        <tr class="receipt__table-header">
          <th class="receipt__table-main-cell">Nom de fichier</th>
          <th>Impression</th>
          <th>Finition</th>
          <th>Options</th>
          <th>Quantité</th>
          <th>Largeur</th>
          <th>Hauteur</th>
          <th>Nb. Orig.</th>
        </tr>
        @foreach($delivery->documents as $document)
          <tr>
            <td class="receipt__table-main-cell">{{ $document->media->first()->file_name }}</td>
            <td>
              {{ $document->article->description }}
              @if ($document->article->type === 'impression' && $document->article->greyscale === true)
                <small class="text-xs">(Noir / Blanc)</small>
              @elseif ($document->article->type === 'impression' && $document->article->greyscale === false)
                <small class="text-xs">(Couleur)</small>
              @endif
            </td>
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