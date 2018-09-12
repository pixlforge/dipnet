@extends ('layouts.app')

@section ('title', "Commande {$order->reference}")

@section ('content')

  @include ('layouts.partials._nav')
  <div class="receipt__header">
    <h1 class="receipt__title">Résumé de la commande {{ $order->reference }}</h1>
  </div>
  <section class="receipt__section">
    <div class="receipt__content">
      <div class="receipt__container">
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
          <div class="receipt__item">
            <h2 class="receipt__item-title">Affaire</h2>
            <p class="receipt__item-content">
              {{ $order->business->name }}
            </p>
          </div>
        </div>
        <div class="receipt__row">
          <div class="receipt__item">
            <h2 class="receipt__item-title">Commandé par</h2>
            <p class="receipt__item-content">{{ $order->user->username }} ({{ $order->user->email }})</p>
          </div>
          <div class="receipt__item">
            <h2 class="receipt__item-title">Adresse de facturation</h2>
            <ul class="receipt__item-list">
              <li>{{ optional($order->contact)->name }}</li>
              <li>{{ optional($order->contact)->address_line1 }}</li>
              <li>{{ optional($order->contact)->address_line2 }}</li>
              <li>{{ optional($order->contact)->zip }} {{ optional($order->contact)->city }}</li>
              <li>{{ optional($order->contact)->phone_number }}</li>
              <li>{{ optional($order->contact)->fax }}</li>
              <li>{{ optional($order->contact)->email }}</li>
            </ul>
          </div>
          <div class="receipt__item">
            <h2 class="receipt__item-title">Status</h2>
            <p class="receipt__item-content">{{ ucfirst($order->status) }}</p>
          </div>
        </div>
      </div>
    </div>
    @foreach ($order->deliveries as $delivery)
      <div class="receipt__content">
        <div class="receipt__container">
          <h1 class="receipt__secondary-title">Livraison {{ $delivery->reference }}</h1>
          <div class="receipt__row">
            <div class="receipt__item">
              <h2 class="receipt__item-title">Adresse de livraison</h2>
              <ul class="receipt__item-list">
                <li>{{ optional($delivery->contact)->name }}</li>
                <li>{{ optional($delivery->contact)->address_line1 }}</li>
                <li>{{ optional($delivery->contact)->address_line2 }}</li>
                <li>{{ optional($delivery->contact)->zip }} {{ optional($delivery->contact)->city }}</li>
                <li>{{ optional($delivery->contact)->phone_number  }}</li>
                <li>{{ optional($delivery->contact)->fax  }}</li>
                <li>{{ optional($delivery->contact)->email  }}</li>
              </ul>
            </div>
            <div class="receipt__item">
              <h2 class="receipt__item-title">Date de livraison</h2>
              <p class="receipt__item-content">
                {{ $delivery->to_deliver_at ? optional($delivery->to_deliver_at)->formatLocalized('%e %B %Y à %H:%M') : "Livraison éclair" }}
              </p>
            </div>
            <div class="receipt__item">
              <h2 class="receipt__item-title">Note</h2>
              <p class="receipt__item-content">{{ $delivery->note ? $delivery->note : 'Aucun commentaire.' }}</p>
            </div>
          </div>
        </div>
        <div class="receipt__container">
          <div class="receipt__row">
            @foreach ($delivery->documents as $document)
              <div class="receipt__item">
                <h2 class="receipt__item-title">{{ $document->media->first()->file_name }}</h2>
                <ul class="receipt__item-list">
                  <li>Finition: {{ ucfirst($document->finish) }}</li>
                  <li>
                    Impression:
                    {{ $document->article->description }}
                    @if ($document->article->type === 'impression' && $document->article->greyscale === true)
                      <small class="text-xs">(Noir / Blanc)</small>
                    @elseif ($document->article->type === 'impression' && $document->article->greyscale === false)
                      <small class="text-xs">(Couleur)</small>
                    @endif
                  </li>
                  <li>Quantité: {{ $document->quantity }}</li>
                  <li>
                    <ul class="receipt__item-list">
                      @foreach ($document->articles as $article)
                        <li>Option: {{ $article->description }}</li>
                      @endforeach
                    </ul>
                  </li>
                </ul>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endforeach
  </section>
  @include('layouts.partials._footer')
@endsection
