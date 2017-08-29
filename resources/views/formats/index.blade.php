@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Formats')

@section ('content')

    <app-formats :data="{{ $formats }}"></app-formats>

    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-12 text-center my-5">--}}
                {{--<h1 class="display-1">Formats</h1>--}}
                {{--<h2 class="text-muted">Liste de tous les formats</h2>--}}
            {{--</div>--}}
            {{--<div class="col-12">--}}
                {{--<p class="text-center mb-5">--}}
                    {{--Il existe actuellement <strong>{{ $formats->count() }}</strong> {{ str_plural('format', $formats->count()) }} au--}}
                    {{--total.--}}
                {{--</p>--}}
                {{--<div class="text-center mb-5">--}}
                    {{--<a href="{{ url('/formats/create') }}" class="btn btn-primary">Ajouter</a>--}}
                {{--</div>--}}
                {{--<div class="card-columns">--}}
                    {{--@foreach ($formats as $format)--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-block">--}}
                                {{--<div class="d-flex justify-content-between">--}}
                                    {{--<h3 class="card-title">--}}
                                        {{--@unless ($format->deleted_at === null)--}}
                                            {{--<i class="fa fa-trash text-danger"></i>--}}
                                        {{--@else--}}
                                            {{--<i class="fa fa-check text-success"></i>--}}
                                        {{--@endunless</h3>--}}

                                    {{--<div class="dropdown">--}}
                                        {{--<a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                            {{--<i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
                                        {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">--}}
                                            {{--@unless ($format->deleted_at === null)--}}
                                                {{--<form method="POST"--}}
                                                      {{--action="{{ url("/formats/{$format->id}/restore") }}">--}}
                                                    {{--{{ method_field('PUT') }}--}}
                                                    {{--{{ csrf_field() }}--}}

                                                    {{--<button class="dropdown-item text-success" type="submit">--}}
                                                        {{--<i class="fa fa-refresh"></i>--}}
                                                        {{--<span class="ml-3">Restaurer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<a class="dropdown-item"--}}
                                                   {{--href="{{ url("/formats/{$format->id}/edit") }}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--<span class="ml-3">Modifier</span>--}}
                                                {{--</a>--}}
                                                {{--<form method="POST" action="{{ url("/formats/{$format->id}") }}">--}}
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

                                    {{--Name--}}
                                    {{--<li class="mt-2 mb-4">--}}
                                        {{--<h2><i class="fa fa-hashtag mr-2"></i> {{ $format->name }}</h2>--}}
                                    {{--</li>--}}

                                    {{--Height--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-arrows-v mr-2"></i> Hauteur</h5>--}}
                                        {{--<span class="text-capitalize">{{ $format->height }}</span>--}}
                                    {{--</li>--}}

                                    {{--Width--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-arrows-h mr-2"></i> Largeur</h5>--}}
                                        {{--<span class="text-capitalize">{{ $format->width }}</span>--}}
                                    {{--</li>--}}

                                    {{--Surface--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-arrows mr-2"></i> Surface</h5>--}}
                                        {{--<span class="text-capitalize">{{ $format->surface }}</span>--}}
                                    {{--</li>--}}


                                    {{--Created at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $format->created_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $format->created_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Modified at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $format->updated_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $format->updated_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Deleted at--}}
                                    {{--@unless($format->deleted_at === null)--}}
                                        {{--<li class="my-4 text-danger">--}}
                                            {{--<h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $format->deleted_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $format->deleted_at->diffForHumans() }}</small></span>--}}
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
