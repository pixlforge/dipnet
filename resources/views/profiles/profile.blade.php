@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="display-3 text-center my-5">Profil</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-4">

                {{--Account--}}
                <div class="card">
                    <div class="card-block">

                        {{--Username--}}
                        <div class="my-4">
                            <h2>
                                <i class="fa fa-user mr-2"></i>
                                <span>{{ $user->username }}</span>
                            </h2>
                        </div>

                        {{--Email--}}
                        <div class="my-4">
                            <h5>
                                <i class="fa fa-envelope mr-2"></i>
                                <span>Adresse E-mail</span>
                            </h5>
                            <span>{{ $user->email }}</span>
                        </div>

                        {{--Contact--}}
                        <div class="my-4">
                            <h5>
                                <i class="fa fa-address-card mr-2"></i>
                                <span>Contact principal</span>
                            </h5>
                            <span>{{ $user->contact->name }}</span>
                        </div>

                        {{--Company--}}
                        <div class="my-4">
                            <h5>
                                <i class="fa fa-industry mr-2"></i>
                                <span>Société</span>
                            </h5>
                            <span>{{ $user->company->name }}</span>
                        </div>

                        <p class="text-center"><small>Inscrit {{ $user->created_at->diffForHumans() }}, le {{ $user->created_at->formatLocalized('%A %d %B %Y') }}.</small></p>

                        <a href="{{ url('/profile/' . $user->id . '/edit') }}" class="btn btn-primary btn-block mt-4">Mettre à jour</a>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-block">

                        {{--Main Contact--}}
                        <h2><i class="fa fa-address-card mr-2"></i> {{ $user->contact->name }}</h2>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection