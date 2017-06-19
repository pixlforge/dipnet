@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="display-1 text-center my-5">Dashboard</h1>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card-columns">

                    {{--Users--}}
                    <div class="card list-group">
                        <a href="{{ route('users') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-users mr-2"></i>
                                <span>Utilisateurs</span>
                            </h4>
                        </a>
                    </div>

                    {{--Formats--}}
                    <div class="card list-group">
                        <a href="{{ route('formats') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-hashtag mr-2"></i>
                                <span>Formats</span>
                            </h4>
                        </a>
                    </div>


                    {{--Compagnies--}}
                    <div class="card list-group">
                        <a href="{{ route('companies') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-industry mr-2"></i>
                                <span>Sociétés</span>
                            </h4>
                        </a>
                    </div>

                    {{--Categories--}}
                    <div class="card list-group">
                        <a href="{{ route('categories') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-tag mr-2"></i>
                                <span>Catégories</span>
                            </h4>
                        </a>
                    </div>

                    {{--Businesses--}}
                    <div class="card list-group">
                        <a href="{{ route('businesses') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-handshake-o mr-2"></i>
                                <span>Affaires</span>
                            </h4>
                        </a>
                    </div>

                    {{--Articles--}}
                    <div class="card list-group">
                        <a href="{{ route('articles') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2"><i class="fa fa-barcode mr-2"></i>
                                <span>Articles</span>
                            </h4>
                        </a>
                    </div>

                    {{--Contacts--}}
                    <div class="card list-group">
                        <a href="{{ route('contacts') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-address-card mr-2"></i>
                                <span>Contacts</span>
                            </h4>
                        </a>
                    </div>

                    {{--Orders--}}
                    <div class="card list-group">
                        <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-shopping-cart mr-2"></i>
                                <span>Commandes</span>
                            </h4>
                        </a>
                    </div>

                    {{--Deliveries--}}
                    <div class="card list-group">
                        <a href="{{ route('deliveries') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-truck mr-2"></i>
                                <span>Livraisons</span>
                            </h4>
                        </a>
                    </div>

                    {{--Documents--}}
                    <div class="card list-group">
                        <a href="{{ route('documents') }}" class="list-group-item list-group-item-action">
                            <h4 class="mt-2">
                                <i class="fa fa-file-o mr-2"></i>
                                <span>Documents</span>
                            </h4>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection