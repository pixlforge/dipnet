@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Businesses</h1>
                <h2 class="text-muted">Liste de toutes les affaires</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $businesses->count() }}</strong> affaires au
                    total.</p>
                <div class="card-columns">
                    @foreach ($businesses as $business)
                        <a class="link-unstyled" href="{{ url('/businesses/' . $business->name) }}">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection