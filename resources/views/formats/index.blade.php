@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Formats</h1>
                <h2 class="text-muted">Liste de tous les formats</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $formats->count() }}</strong> formats au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/formats/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($formats as $format)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">{{ $format->name }}</h3>

                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            @unless ($format->deleted_at === null)
                                                <form method="POST" action="{{ url("/formats/{$format->name}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item" href="{{ url("/formats/{$format->name}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/formats/{$format->name}") }}">
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
                                    <li><em>Width</em>: {{ $format->width }}</li>
                                    <li><em>Height</em>: {{ $format->height }}</li>
                                    <li><em>Surface</em>: {{ $format->surface }}</li>
                                    <li>
                                        <em>Created at</em>: {{ $format->created_at->format('d M Y') }}
                                        <small>{{ $format->created_at->diffForHumans() }}</small>
                                    </li>
                                    <li>
                                        <em>Updated at</em>: {{ $format->updated_at->format('d M Y') }}
                                        <small>{{ $format->updated_at->diffForHumans() }}</small>
                                    </li>
                                    @unless($format->deleted_at === null)
                                        <li>
                                            <div class="bg-danger text-white">
                                                <em>Deleted at</em>: {{ $format->deleted_at->format('d M Y') }}
                                                <small>{{ $format->deleted_at->diffForHumans() }}</small>
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
