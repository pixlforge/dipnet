@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Companies</h1>
                <h2 class="text-muted">Liste de toutes les sociétés</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $companies->count() }}</strong> sociétés au
                    total.</p>
                <div class="card-columns">
                    @foreach ($companies as $company)
                        <a class="link-unstyled" href="{{ url('/businesses/' . $company->name) }}">
                            <div class="card">
                                <div class="card-block">
                                    <h3 class="card-title">{{ $company->name }}</h3>
                                    <ul class="list-unstyled">

                                        <li><em>Créé par</em>: {{ $company->created_by_username }}</li>
                                        <li>
                                            <em>Created at</em>: {{ $company->created_at->format('d M Y') }}
                                            <small>{{ $company->created_at->diffForHumans() }}</small>
                                        </li>
                                        <li>
                                            <em>Updated at</em>: {{ $company->updated_at->format('d M Y') }}
                                            <small>{{ $company->updated_at->diffForHumans() }}</small>
                                        </li>
                                        {{--<li>--}}
                                        {{--<em>Deleted at</em>: {{ $company->deleted_at }}--}}
                                        {{--<small>{{ $company->deleted_at->diffForHumans() }}</small>--}}
                                        {{--</li>--}}
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