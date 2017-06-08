@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Businesses</h1>
                <h2 class="text-muted">Voir l'affaire {{ $business->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-8 offset-md-2 mt-5">
                <a class="link-unstyled" href="{{ url('/businesses/' . $business->name . '/edit') }}">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">{{ $business->name }}</h3>
                            <ul class="list-unstyled">
                                <li><em>Reference</em>: {{ $business->reference }}</li>
                                <li><em>Description</em>: {{ $business->description }}</li>
                                <li><em>Company</em>: TODO</li>
                                <li><em>Contact</em>: TODO</li>
                                <li><em>Créé par</em>: {{ $business->created_by_username }}</li>
                                <li>
                                    <em>Created at</em>: {{ $business->created_at->format('d M Y') }}
                                    <small>{{ $business->created_at->diffForHumans() }}</small>
                                </li>
                                <li>
                                    <em>Updated at</em>: {{ $business->updated_at->format('d M Y') }}
                                    <small>{{ $business->updated_at->diffForHumans() }}</small>
                                </li>
                                @unless($business->deleted_at === null)
                                    <li>
                                        <div class="bg-danger text-white">
                                            <em>Deleted at</em>: {{ $business->deleted_at->format('d M Y') }}
                                            <small>{{ $business->deleted_at->diffForHumans() }}</small>
                                        </div>
                                    </li>
                                @endunless
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection