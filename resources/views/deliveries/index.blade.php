@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Deliveries</h1>
                <h2 class="text-muted">Liste de toutes les livraisons</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $deliveries->count() }}</strong>
                    livraisons au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/deliveries/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($deliveries as $delivery)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">{{ $delivery->id }}</h3>

                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="dropdownMenuLink">
                                            @unless ($delivery->deleted_at === null)
                                                <form method="POST"
                                                      action="{{ url("/deliveries/{$delivery->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url("/deliveries/{$delivery->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/deliveries/{$delivery->id}") }}">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-times"></i>
                                                        <span class="ml-3">Supprimer</span>
                                                    </button>
                                                </form>
                                            @endunless
                                        </div>
                                    </div>

                                </div>
                                <ul class="list-unstyled">
                                    @if ($delivery->internal_comment)
                                        <li><em>Description</em>: {{ $delivery->internal_comment }}</li>
                                    @else
                                        <li>Aucun commentaire fourni</li>
                                    @endif
                                    <li><em>ID</em>: {{ $delivery->id }}</li>

                                    {{--Order--}}
                                    @unless ($delivery->order->deleted_at === null)
                                        <li>
                                            <div class="bg-danger text-white">
                                                <em>Commande</em>: {{ $delivery->order->reference }}
                                            </div>
                                        </li>
                                    @endunless

                                    {{--Contact--}}
                                    <li><em>Contact</em>: {{ $delivery->contact->name }}</li>
                                    <li>
                                        <em>Created at</em>: {{ $delivery->created_at->format('d M Y') }}
                                        <small>{{ $delivery->created_at->diffForHumans() }}</small>
                                    </li>
                                    <li>
                                        <em>Updated at</em>: {{ $delivery->updated_at->format('d M Y') }}
                                        <small>{{ $delivery->updated_at->diffForHumans() }}</small>
                                    </li>
                                    @unless($delivery->deleted_at === null)
                                        <li>
                                            <div class="bg-danger text-white">
                                                <em>Deleted at</em>: {{ $delivery->deleted_at->format('d M Y') }}
                                                <small>{{ $delivery->deleted_at->diffForHumans() }}</small>
                                            </div>
                                        </li>
                                    @endunless
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection