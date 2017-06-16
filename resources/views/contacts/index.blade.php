@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Contacts</h1>
                <h2 class="text-muted">Liste de tous les contacts</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $contacts->count() }}</strong> contacts au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/contacts/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($contacts as $contact)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        @unless ($contact->deleted_at === null)
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
                                            @unless ($contact->deleted_at === null)
                                                <form method="POST"
                                                      action="{{ url("/contacts/{$contact->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item text-success" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url("/contacts/{$contact->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/contacts/{$contact->id}") }}">
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
                                        <i class="fa fa-address-card fa-2x mr-3"></i>
                                        <span class="h2">{{ $contact->name }}</span>
                                    </li>

                                    {{--Address--}}
                                    <li class="my-4">
                                        <h5>Adresse</h5>
                                        <i class="fa fa-location-arrow fa-lg mr-3"></i>
                                        <span>{{ $contact->address_line1 }}</span><br>
                                        @isset ($contact->address_line2)
                                            <span>{{ $contact->address_line2 }}</span><br>
                                        @endisset
                                        <span>{{ $contact->zip }} &ndash; {{ $contact->city }}</span>
                                    </li>

                                    {{--Phone--}}
                                    <li class="my-4">
                                        <h5>Téléphone</h5>
                                        <i class="fa fa-phone fa-lg mr-3"></i>
                                        <span>{{ $contact->phone_number }}</span>
                                    </li>

                                    {{--Fax--}}
                                    @unless ($contact->fax === null)
                                        <li class="my-4">
                                            <h5>Fax</h5>
                                            <i class="fa fa-fax fa-lg mr-3"></i>
                                            <span>{{ $contact->fax }}</span>
                                        </li>
                                    @endunless

                                    {{--Email--}}
                                    <li class="my-4">
                                        <h5>E-mail</h5>
                                        <i class="fa fa-envelope fa-lg mr-3"></i>
                                        <span>{{ $contact->email }}</span>
                                    </li>

                                    {{--Company--}}
                                    @unless ($contact->company === null)
                                        <li class="my-4">
                                            <h5>Compagnie</h5>
                                            <i class="fa fa-industry fa-lg mr-3"></i>
                                            <span>{{ $contact->company->name }}</span>
                                        </li>
                                    @endunless

                                    {{--Created by--}}
                                    <li class="my-4">
                                        <h5>Créé par</h5>
                                        <i class="fa fa-user fa-lg mr-3"></i>
                                        <span>{{ $contact->created_by_username }}</span>
                                    </li>

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5>Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-check-o mr-3"></i>
                                                <span>{{ $contact->created_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $contact->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5>Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-plus-o mr-3"></i>
                                                <span>{{ $contact->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $contact->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Deleted at--}}
                                    @unless($contact->deleted_at === null)
                                        <li class="my-4 text-danger">
                                            <h5>Date de suppression</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div>
                                                    <i class="fa fa-trash fa-lg mr-3"></i>
                                                    <span>{{ $contact->deleted_at->format('d M Y') }}</span>
                                                </div>
                                                <span><small>{{ $contact->deleted_at->diffForHumans() }}</small></span>
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