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
                        <h2>
                            <i class="fa fa-user mr-2"></i>
                            <span>{{ $user->username }}</span>
                        </h2>

                        {{--Email--}}
                        <h5 class="my-3">
                            <i class="fa fa-envelope mr-2"></i>
                            <span>{{ $user->email }}</span>
                        </h5>

                        {{--Contact--}}
                        <h5 class="my-3">
                            <i class="fa fa-address-card mr-2"></i>
                            <span>{{ $user->contact->name }}</span>
                        </h5>

                        {{--Company--}}
                        <h5 class="my-3">
                            <i class="fa fa-industry mr-2"></i>
                            <span>{{ $user->company->name }}</span>
                        </h5>

                        <p>Inscrit {{ $user->created_at->diffForHumans() }}, le {{ $user->created_at->formatLocalized('%A %d %B %Y') }}.</p>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-md-6 col-lg-8">
                <div class="card">
                    <div class="card-block">

                        <h2>Activity</h2>

                        {{--Orders--}}


                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection