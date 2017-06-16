@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Businesses</h1>
                <h2 class="text-muted">Liste de toutes les affaires</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $businesses->count() }}</strong> affaires au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/businesses/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($businesses as $business)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        @unless ($business->deleted_at === null)
                                            <i class="fa fa-trash text-danger"></i>
                                        @else
                                            <i class="fa fa-check text-success"></i>
                                        @endunless
                                    </h3>
                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="dropdownMenuLink">
                                            @unless ($business->deleted_at === null)
                                                <form method="POST"
                                                      action="{{ url("/businesses/{$business->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item text-success" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url("/businesses/{$business->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/businesses/{$business->id}") }}">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="fa fa-trash"></i>
                                                        <span class="ml-3">Supprimer</span>
                                                    </button>
                                                </form>
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-unstyled">

                                    {{--Name--}}
                                    <li class="mt-2 mb-4">
                                        <i class="fa fa-handshake-o fa-2x mr-3"></i>
                                        <span class="h2">{{ $business->name }}</span>
                                    </li>

                                    {{--Reference--}}
                                    @isset ($business->reference)
                                    <li class="my-4">
                                        <h5>Référence</h5>
                                        <i class="fa fa-hashtag fa-lg mr-3"></i>
                                        <span>{{ $business->reference }}</span><br>
                                    </li>
                                    @endisset

                                    {{--Description--}}
                                    @isset ($business->description)
                                        <li class="my-4">
                                            <h5>Description</h5>
                                            <i class="fa fa-comment fa-lg mr-3"></i>
                                            <span>{{ $business->description}}</span><br>
                                        </li>
                                    @endisset

                                    {{--Company--}}
                                    <li class="my-4">
                                        <h5>Société</h5>
                                        <i class="fa fa-industry fa-lg mr-3"></i>
                                        <span>{{ $business->company->name }}</span>
                                    </li>

                                    {{--Contact--}}
                                    @isset ($business->contact)
                                        <li class="my-4">
                                            <h5>Contact</h5>
                                            <i class="fa fa-location-arrow fa-lg mr-3"></i>
                                            <span>{{ $business->contact->name }}</span>
                                        </li>
                                    @endisset

                                    {{--Created by--}}
                                    <li class="my-4">
                                        <h5>Créé par</h5>
                                        <i class="fa fa-user fa-lg mr-3"></i>
                                        <span>{{ $business->created_by_username }}</span>
                                    </li>

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5>Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-check-o mr-3"></i>
                                                <span>{{ $business->created_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $business->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5>Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-plus-o mr-3"></i>
                                                <span>{{ $business->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $business->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Deleted at--}}
                                    @unless($business->deleted_at === null)
                                        <li class="my-4 text-danger">
                                            <h5>Date de suppression</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div>
                                                    <i class="fa fa-trash fa-lg mr-3"></i>
                                                    <span>{{ $business->deleted_at->format('d M Y') }}</span>
                                                </div>
                                                <span><small>{{ $business->deleted_at->diffForHumans() }}</small></span>
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