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
                                        <h2><i class="fa fa-address-card mr-2"></i> {{ $contact->name }}</h2>
                                    </li>

                                    {{--Address--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-location-arrow mr-2"></i> Adresse</h5>
                                        <div>{{ $contact->address_line1 }}</div>
                                        @isset ($contact->address_line2)
                                            <div>{{ $contact->address_line2 }}</div>
                                        @endisset
                                        <span>{{ $contact->zip }} &ndash; {{ $contact->city }}</span>
                                    </li>

                                    {{--Phone--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-phone mr-2"></i> Téléphone</h5>
                                        <span>{{ $contact->phone_number }}</span>
                                    </li>

                                    {{--Fax--}}
                                    @unless ($contact->fax === null)
                                        <li class="my-4">
                                            <h5><i class="fa fa-fax mr-2"></i> Fax</h5>
                                            <span>{{ $contact->fax }}</span>
                                        </li>
                                    @endunless

                                    {{--Email--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-envelope mr-2"></i> E-mail</h5>
                                        <span>{{ $contact->email }}</span>
                                    </li>

                                    {{--Company--}}
                                    @unless ($contact->company === null)
                                        <li class="my-4">
                                            <h5><i class="fa fa-industry mr-2"></i> Compagnie</h5>
                                            <span>{{ $contact->company->name }}</span>
                                        </li>
                                    @endunless

                                    {{--Created by--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-industry mr-2"></i> Créé par</h5>
                                        <span>{{ $contact->created_by_username }}</span>
                                    </li>

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <span>{{ $contact->created_at->format('d M Y') }}</span>
                                            <span><small>{{ $contact->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <span>{{ $contact->updated_at->format('d M Y') }}</span>
                                            <span><small>{{ $contact->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Deleted at--}}
                                    @unless($contact->deleted_at === null)
                                        <li class="my-4 text-danger">
                                            <h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <span>{{ $contact->deleted_at->format('d M Y') }}</span>
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