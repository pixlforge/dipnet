@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Categories</h1>
                <h2 class="text-muted">Voir la catégorie {{ $category->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-8 offset-md-2 mt-5">
                <a class="link-unstyled" href="{{ url('/categories/' . $category->name . '/edit') }}">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">{{ $category->name }}</h3>
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
            </div>
        </div>
    </div>

@endsection
