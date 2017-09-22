@extends ('layouts.app')

@section ('title', 'Utilisateurs')

@section ('content')

    @include ('layouts.nav')

    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-12 text-center my-5">--}}
                {{--<h1 class="display-1">Users</h1>--}}
                {{--<h2 class="text-muted">Liste de tous les utilisateurs</h2>--}}
            {{--</div>--}}
            {{--<div class="col-12">--}}
                {{--<p class="text-center mb-5">--}}
                    {{--Il existe actuellement <strong>{{ $users->count() }}</strong> {{ str_plural('utilisateurs', $users->count()) }} au total.--}}
                {{--</p>--}}
                {{--<div class="text-center mb-5">--}}
                    {{--<a href="{{ url('/users/create') }}" class="btn btn-primary">Ajouter</a>--}}
                {{--</div>--}}
                {{--<div class="card-columns">--}}
                    {{--@foreach ($users as $user)--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-block">--}}
                                {{--<div class="d-flex justify-content-between">--}}
                                    {{--<h3 class="card-title">--}}
                                        {{--@unless ($user->deleted_at === null)--}}
                                            {{--<i class="fa fa-trash text-danger"></i>--}}
                                        {{--@else--}}
                                            {{--<i class="fa fa-check text-success"></i>--}}
                                        {{--@endunless--}}
                                    {{--</h3>--}}
                                    {{--<div class="dropdown">--}}
                                        {{--<a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"--}}
                                           {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                            {{--<i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
                                        {{--<div class="dropdown-menu dropdown-menu-right"--}}
                                             {{--aria-labelledby="dropdownMenuLink">--}}
                                            {{--@unless ($user->deleted_at === null)--}}
                                                {{--<form method="POST"--}}
                                                      {{--action="{{ url("/users/{$user->id}/restore") }}">--}}
                                                    {{--{{ method_field('PUT') }}--}}
                                                    {{--{{ csrf_field() }}--}}

                                                    {{--<button class="dropdown-item text-success" type="submit">--}}
                                                        {{--<i class="fa fa-refresh"></i>--}}
                                                        {{--<span class="ml-3">Restaurer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<a class="dropdown-item"--}}
                                                   {{--href="{{ url("/users/{$user->id}/edit") }}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--<span class="ml-3">Modifier</span>--}}
                                                {{--</a>--}}
                                                {{--<form method="POST" action="{{ url("/users/{$user->id}") }}">--}}
                                                    {{--{{ method_field('DELETE') }}--}}
                                                    {{--{{ csrf_field() }}--}}
                                                    {{--<button class="dropdown-item text-danger" type="submit">--}}
                                                        {{--<i class="fa fa-trash"></i>--}}
                                                        {{--<span class="ml-3">Supprimer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@endunless--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<ul class="list-unstyled">--}}

                                    {{--Username--}}
                                    {{--<li class="mt-2 mb-4">--}}
                                        {{--<h2><i class="fa fa-user mr-2"></i> {{ $user->username }}</h2>--}}
                                    {{--</li>--}}

                                    {{--Role--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-flash mr-2"></i> Role</h5>--}}
                                        {{--<span class="text-capitalize">{{ $user->role }}</span>--}}
                                    {{--</li>--}}

                                    {{--Email--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-envelope mr-2"></i> E-mail</h5>--}}
                                        {{--<span>{{ $user->email }}</span>--}}
                                        {{--@if ($user->email_validated === 1)--}}
                                            {{--<i class="fa fa-check-circle text-info"></i>--}}
                                        {{--@endif--}}
                                    {{--</li>--}}

                                    {{--@isset ($user->contact_id)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-address-card mr-2"></i> Contact principal</h5>--}}
                                            {{--<span>{{ $user->contact->name }}</span>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--@isset ($user->company_id)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-industry mr-2"></i> Société</h5>--}}
                                            {{--<span>{{ $user->company->name }}</span>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--@isset ($user->last_login_at)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-industry mr-2"></i> Dernière connexion</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $user->last_login_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $user->last_login_at->diffForHumans() }}</small></span>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--Created at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $user->created_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $user->created_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Modified at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $user->updated_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $user->updated_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Deleted at--}}
                                    {{--@unless($user->deleted_at === null)--}}
                                        {{--<li class="my-4 text-danger">--}}
                                            {{--<h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $user->deleted_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $user->deleted_at->diffForHumans() }}</small></span>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endunless--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection