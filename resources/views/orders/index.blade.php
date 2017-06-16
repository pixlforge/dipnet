@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Orders</h1>
                <h2 class="text-muted">Liste de toutes les commandes</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $orders->count() }}</strong> commandes au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/orders/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($orders as $order)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">{{ $order->reference }}</h3>

                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            @unless ($order->deleted_at === null)
                                                <form method="POST" action="{{ url("/orders/{$order->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item" href="{{ url("/orders/{$order->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/orders/{$order->id}") }}">
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
                                    <li><em>Status</em>: {{ $order->status }}</li>
                                    <li><em>Affaire</em>: {{ $order->business->name }}</li>
                                    <li><em>Contact</em>: {{ $order->contact->name }}</li>
                                    <li><em>Créé par</em>: {{ $order->user->username }}</li>
                                    <li>
                                        <em>Created at</em>: {{ $order->created_at->format('d M Y') }}
                                        <small>{{ $order->created_at->diffForHumans() }}</small>
                                    </li>
                                    <li>
                                        <em>Updated at</em>: {{ $order->updated_at->format('d M Y') }}
                                        <small>{{ $order->updated_at->diffForHumans() }}</small>
                                    </li>
                                    @unless($order->deleted_at === null)
                                        <li>
                                            <div class="bg-danger text-white">
                                                <em>Deleted at</em>: {{ $order->deleted_at->format('d M Y') }}
                                                <small>{{ $order->deleted_at->diffForHumans() }}</small>
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
