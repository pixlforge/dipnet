@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Articles</h1>
                <h2 class="text-muted">Liste de tous les articles</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $articles->count() }}</strong> articles au
                    total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/articles/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($articles as $article)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">{{ $article->reference }}</h3>

                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            @unless ($article->deleted_at === null)
                                                <form method="POST" action="{{ url("/articles/{$article->reference}/restore") }}">
                                                    {{ method_field('PUT') }}
                                                    {{ csrf_field() }}

                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-refresh"></i>
                                                        <span class="ml-3">Restaurer</span>
                                                    </button>
                                                </form>
                                            @else
                                                <a class="dropdown-item" href="{{ url("/articles/{$article->reference}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/articles/{$article->reference}") }}">
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
                                    @if ($article->description)
                                        <li><em>Description</em>: {{ $article->description }}</li>
                                    @else
                                        <li>Aucune description fournie</li>
                                    @endif
                                    <li><em>Type</em>: {{ $article->type }}</li>
                                    <li><em>Catégorie</em>: {{ $article->category->name }}</li>
                                    <li>
                                        <em>Created at</em>: {{ $article->created_at->format('d M Y') }}
                                        <small>{{ $article->created_at->diffForHumans() }}</small>
                                    </li>
                                    <li>
                                        <em>Updated at</em>: {{ $article->updated_at->format('d M Y') }}
                                        <small>{{ $article->updated_at->diffForHumans() }}</small>
                                    </li>
                                    @unless($article->deleted_at === null)
                                        <li>
                                            <div class="bg-danger text-white">
                                                <em>Deleted at</em>: {{ $article->deleted_at->format('d M Y') }}
                                                <small>{{ $article->deleted_at->diffForHumans() }}</small>
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