@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Users</h1>
                <h2 class="text-muted">Liste de tous les utilisateurs</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $users->count() }}</strong> utilisateurs au total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/users/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($users as $user)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        @unless ($user->deleted_at === null)
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
                                            @unless ($user->deleted_at === null)
                                                <form method="POST"
                                                      action="{{ url("/users/{$user->id}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item text-success" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url("/users/{$user->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/users/{$user->id}") }}">
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

                                    {{--Username    --}}
                                    <li class="mt-2 mb-4">
                                        <i class="fa fa-user fa-2x mr-3"></i>
                                        <span class="h2">{{ $user->username }}</span>
                                    </li>

                                    {{--Role--}}
                                    <li class="my-4">
                                        <h5>Role</h5>
                                        <i class="fa fa-flash fa-lg mr-3"></i>
                                        <span class="text-capitalize">{{ $user->role }}</span>
                                    </li>

                                    {{--Email--}}
                                    <li class="my-4">
                                        <h5>E-mail</h5>
                                        <i class="fa fa-envelope fa-lg mr-3"></i>
                                        <span>{{ $user->email }}</span>
                                        @if ($user->email_validated === 1)
                                            <i class="fa fa-check-circle text-info"></i>
                                        @endif
                                    </li>

                                    @isset ($user->contact_id)
                                        <li class="my-4">
                                            <h5>Contact principal</h5>
                                            <i class="fa fa-address-card fa-lg mr-3"></i>
                                            <span>{{ $user->contact->name }}</span>
                                        </li>
                                    @endisset

                                    @isset ($user->company_id)
                                        <li class="my-4">
                                            <h5>Société</h5>
                                            <i class="fa fa-industry fa-lg mr-3"></i>
                                            <span>{{ $user->company->name }}</span>
                                        </li>
                                    @endisset

                                    @isset ($user->last_login_at)
                                        <li class="my-4">
                                            <h5>Dernière connexion</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div>
                                                    <i class="fa fa-industry fa-lg mr-3"></i>
                                                    <span>{{ $user->last_login_at->format('D, d M Y') }}</span>
                                                </div>
                                                <span><small>{{ $user->last_login_at->diffForHumans() }}</small></span>
                                            </div>
                                        </li>
                                    @endisset

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5>Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-check-o mr-3"></i>
                                                <span>{{ $user->created_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $user->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5>Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-plus-o mr-3"></i>
                                                <span>{{ $user->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $user->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Deleted at--}}
                                    @unless($user->deleted_at === null)
                                        <li class="my-4 text-danger">
                                            <h5>Date de suppression</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div>
                                                    <i class="fa fa-trash fa-lg mr-3"></i>
                                                    <span>{{ $user->deleted_at->format('d M Y') }}</span>
                                                </div>
                                                <span><small>{{ $user->deleted_at->diffForHumans() }}</small></span>
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