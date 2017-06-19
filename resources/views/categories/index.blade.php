@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Categories</h1>
                <h2 class="text-muted">Liste de toutes les catégories</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">
                    Il existe actuellement <strong>{{ $categories->count() }}</strong> {{ str_plural('catégorie', $categories->count()) }} au total.
                </p>
                <div class="text-center mb-5">
                    <a href="{{ url('/categories/create') }}" class="btn btn-primary">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($categories as $category)
                        <a class="link-unstyled" href="{{ url('/categories/' . $category->name) }}">
                            <div class="card">
                                <div class="card-block">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">
                                            <i class="fa fa-check text-success"></i>
                                        </h3>
                                        <div class="dropdown">
                                            <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item"
                                                   href="{{ url("/categories/{$category->id}/edit") }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="ml-3">Modifier</span>
                                                </a>
                                                <form method="POST" action="{{ url("/categories/{$category->id}") }}">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="fa fa-trash"></i>
                                                        <span class="ml-3">Supprimer</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <ul class="list-unstyled">

                                        {{--Name--}}
                                        <li class="mt-2 mb-4">
                                            <h2><i class="fa fa-tag mr-2"></i> {{ $category->name }}</h2>
                                        </li>

                                        {{--Created at--}}
                                        <li class="my-4">
                                            <h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <span>{{ $category->created_at->format('d M Y') }}</span>
                                                <span><small>{{ $category->created_at->diffForHumans() }}</small></span>
                                            </div>
                                        </li>

                                        {{--Modified at--}}
                                        <li class="my-4">
                                            <h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>
                                            <div class="d-flex flex-row justify-content-between">
                                                <span>{{ $category->updated_at->format('d M Y') }}</span>
                                                <span><small>{{ $category->updated_at->diffForHumans() }}</small></span>
                                            </div>
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