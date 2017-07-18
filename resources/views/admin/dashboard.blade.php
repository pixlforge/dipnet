@include('layouts.nav')

@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-5">Dashboard</h1>
            </div>

            {{--Users--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('users') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-users mr-2"></i>
                            <span>Utilisateurs</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Formats--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('formats') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-hashtag mr-2"></i>
                            <span>Formats</span>
                        </h5>
                    </a>
                </div>
            </div>


            {{--Compagnies--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('companies') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-industry mr-2"></i>
                            <span>Sociétés</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Categories--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('categories') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-tag mr-2"></i>
                            <span>Catégories</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Businesses--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('businesses') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-handshake-o mr-2"></i>
                            <span>Affaires</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Articles--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('articles') }}">
                        <h5 class="mt-2"><i class="fa fa-barcode mr-2"></i>
                            <span>Articles</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Contacts--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('contacts') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-address-card mr-2"></i>
                            <span>Contacts</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Orders--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('orders') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-shopping-cart mr-2"></i>
                            <span>Commandes</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Deliveries--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('deliveries') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-truck mr-2"></i>
                            <span>Livraisons</span>
                        </h5>
                    </a>
                </div>
            </div>

            {{--Documents--}}
            <div class="col-xs-12 col-md-3 my-2">
                <div class="card dashboard-card">
                    <a href="{{ route('documents') }}">
                        <h5 class="mt-2">
                            <i class="fa fa-file-o mr-2"></i>
                            <span>Documents</span>
                        </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection