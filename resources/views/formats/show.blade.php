@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Formats</h1>
                <h2 class="text-muted">Voir le format {{ $format->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-8 offset-md-2 mt-5">
                <a class="link-unstyled" href="{{ url('/formats/' . $format->name . '/edit') }}">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">{{ $format->name }}</h3>
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
                </a>
            </div>
        </div>
    </div>

@endsection
