@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Categories</h1>
                <h2 class="text-muted">Liste de toutes les catégories</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $categories->count() }}</strong> catégories au total.</p>
                <div class="text-center mb-5">
                    <a href="{{ url('/categories/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($categories as $category)
                        <a class="link-unstyled" href="{{ url('/categories/' . $category->name) }}">
                            <div class="card">
                                <div class="card-block">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">{{ $category->name }}</h3>

                                        <div class="dropdown">
                                            <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="{{ url("/categories/{$category->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/categories/{$category->id}") }}">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="fa fa-times"></i>
                                                        <span class="ml-3">Supprimer</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <ul class="list-unstyled">
                                        <li>
                                            <em>Created at</em>: {{ $category->created_at->format('d M Y') }}
                                            <small>{{ $category->created_at->diffForHumans() }}</small>
                                        </li>
                                        <li>
                                            <em>Updated at</em>: {{ $category->updated_at->format('d M Y') }}
                                            <small>{{ $category->updated_at->diffForHumans() }}</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection