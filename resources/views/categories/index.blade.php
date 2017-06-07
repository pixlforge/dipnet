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
                <div class="card-columns">
                    @foreach ($categories as $category)
                        <a class="link-unstyled" href="{{ url('/categories/' . $category->name) }}">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection