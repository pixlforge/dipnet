@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Companies</h1>
                <h2 class="text-muted">Liste de toutes les sociétés</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $companies->count() }}</strong> sociétés
                    au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/companies/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($companies as $company)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        @unless ($company->deleted_at === null)
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
                                            @unless ($company->deleted_at === null)
                                                <form method="POST"
                                                      action="{{ url("/companies/{$company->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item text-success" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url("/companies/{$company->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/companies/{$company->id}") }}">
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
                                        <i class="fa fa-industry fa-2x mr-3"></i>
                                        <span class="h2">{{ $company->name }}</span>
                                    </li>

                                    {{--Status--}}
                                    <li class="my-4">
                                        <h5>Status</h5>
                                        <i class="fa fa-dashboard fa-lg mr-3"></i>
                                        <span class="text-capitalize">{{ $company->status }}</span>
                                    </li>

                                    {{--Description--}}
                                    @isset ($company->description)
                                        <li class="my-4">
                                            <h5>Description</h5>
                                            <i class="fa fa-comment fa-lg mr-3"></i>
                                            <span>{{ $company->description }}</span>
                                        </li>
                                    @endisset

                                    {{--Created by--}}
                                    <li class="my-4">
                                        <h5>Créé par</h5>
                                        <i class="fa fa-user fa-lg mr-3"></i>
                                        <span>{{ $company->created_by_username }}</span>
                                    </li>

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5>Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-check-o mr-3"></i>
                                                <span>{{ $company->created_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $company->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5>Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-plus-o mr-3"></i>
                                                <span>{{ $company->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $company->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Deleted at--}}
                                    @unless($company->deleted_at === null)
                                        <li class="my-4 text-danger">
                                            <h5>Date de suppression</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div>
                                                    <i class="fa fa-trash fa-lg mr-3"></i>
                                                    <span>{{ $company->deleted_at->format('d M Y') }}</span>
                                                </div>
                                                <span><small>{{ $company->deleted_at->diffForHumans() }}</small></span>
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