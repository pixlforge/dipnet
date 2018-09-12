@if (config('app.name') === 'Dipnet')
<img src="{{ config('app.url') . '/img/logos/header-dip.gif' }}" alt="Logo Dip">
@elseif (config('app.name') === 'Multicop')
<img src="{{ config('app.url') . '/img/logos/header-multicop.png' }}" alt="Logo Multicop">
@endif

@component('mail::message')
# Réception de votre commande n° {{ $order->reference }}

Votre commande nous est bien parvenue et nous vous assurons qu'elle sera traitée dans les délais le plus brefs.

<br>

# Commande
@component('mail::panel')
## Auteur de la commande
{{ $order->user->username }}<br>
{{ $order->user->email }}

## Affaire
{{ $order->business->name }}

## Adresse de facturation
{{ $order->contact->name }}<br>
{{ $order->contact->address_line1 }}<br>
@if ($order->contact->address_line2)
{{ $order->contact->address_line2 }}<br>
@endif
{{ $order->contact->zip }} {{ $order->contact->city }}<br>
@if ($order->contact->phone_number)
{{ $order->contact->phone_number }}<br>
@endif
@if ($order->contact->fax)
{{ $order->contact->fax }}<br>
@endif
{{ $order->contact->email }}
@endcomponent

@foreach ($order->deliveries as $delivery)
<br>
# Livraison {{ $delivery->reference }}
@component('mail::panel')
## Adresse de livraison
@if ($delivery->contact)
{{ $delivery->contact->name }}<br>
{{ $delivery->contact->address_line1 }}<br>
@if ($delivery->contact->address_line2)
{{ $delivery->contact->address_line2 }}<br>
@endif
{{ $delivery->contact->zip }} {{ $delivery->contact->city }}<br>
@if ($delivery->contact->phone_number)
{{ $delivery->contact->phone_number }}<br>
@endif
@if ($delivery->contact->fax)
{{ $delivery->contact->fax }}<br>
@endif
{{ $delivery->contact->email }}
@else
À récupérer sur place.
@endif

## Documents
@foreach ($delivery->documents as $document)

### {{ $document->media->first()->file_name }}<br>

Impression: {{ $document->article->description }}
@if ($document->article->type === 'impression' && $document->article->greyscale === true)
<small>(Noir / Blanc)</small>
@elseif ($document->article->type === 'impression' && $document->article->greyscale === false)
<small>(Couleur)</small>
@endif<br>
@if ($document->finish === 'roulé')
Finition: Roulé<br>
@elseif ($document->finish === 'plié')
Finition: Plié<br>
@endif
Quantité: {{ $document->quantity }}<br>

@foreach ($document->articles as $article)
Option: {{ $article->description }}<br>
@endforeach

@endforeach
@endcomponent
@endforeach

@component('mail::button', ['url' => config('app.url') . '/commandes/' . $order->reference . '/details', 'color' => 'red'])
Visualiser ma commande
@endcomponent

Nous vous remercions pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
