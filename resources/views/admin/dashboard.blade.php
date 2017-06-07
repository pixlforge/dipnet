@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="display-1 text-center my-5">Dashboard</h1>
            </div>
            <div class="col-12">
                <div class="card-columns">

                    {{--Formats--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Formats</h4>
                            <div class="list-group">
                                <a href="{{ url('/formats') }}" class="list-group-item list-group-item-action">Tous les formats</a>
                                <a href="{{ url('/formats/create') }}" class="list-group-item list-group-item-action">Créer un format</a>
                            </div>
                        </div>
                    </div>

                    {{--Compagnies--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Sociétés</h4>
                            <div class="list-group">
                                <a href="{{ url('/companies') }}" class="list-group-item list-group-item-action">Toutes les sociétés</a>
                                <a href="{{ url('/companies/create') }}" class="list-group-item list-group-item-action">Créer une société</a>
                            </div>
                        </div>
                    </div>

                    {{--Categories--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Catégories</h4>
                            <div class="list-group">
                                <a href="{{ url('/categories') }}" class="list-group-item list-group-item-action">Toutes les catégories</a>
                                <a href="{{ url('/categories/create') }}" class="list-group-item list-group-item-action">Créer une catégorie</a>
                            </div>
                        </div>
                    </div>

                    {{--Businesses--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Affaires</h4>
                            <div class="list-group">
                                <a href="{{ url('/businesses') }}" class="list-group-item list-group-item-action">Toutes les affaires</a>
                                <a href="{{ url('/businesses/create') }}" class="list-group-item list-group-item-action">Créer une affaire</a>
                            </div>
                        </div>
                    </div>

                    {{--Articles--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Articles</h4>
                            <div class="list-group">
                                <a href="{{ url('/articles') }}" class="list-group-item list-group-item-action">Tous les articles</a>
                                <a href="{{ url('/articles/create') }}" class="list-group-item list-group-item-action">Créer un article</a>
                            </div>
                        </div>
                    </div>

                    {{--Contacts--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Contacts</h4>
                            <div class="list-group">
                                <a href="{{ url('/contacts') }}" class="list-group-item list-group-item-action">Tous les contacts</a>
                                <a href="{{ url('/contacts/create') }}" class="list-group-item list-group-item-action">Créer un contact</a>
                            </div>
                        </div>
                    </div>

                    {{--Orders--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Commandes</h4>
                            <div class="list-group">
                                <a href="{{ url('/orders') }}" class="list-group-item list-group-item-action">Toutes les commandes</a>
                                <a href="{{ url('/orders/create') }}" class="list-group-item list-group-item-action">Créer une commande</a>
                            </div>
                        </div>
                    </div>

                    {{--Deliveries--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Livraisons</h4>
                            <div class="list-group">
                                <a href="{{ url('/deliveries') }}" class="list-group-item list-group-item-action">Toutes les livraisons</a>
                                <a href="{{ url('/deliveries/create') }}" class="list-group-item list-group-item-action">Créer une livraison</a>
                            </div>
                        </div>
                    </div>

                    {{--Documents--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Documents</h4>
                            <div class="list-group">
                                <a href="{{ url('/documents') }}" class="list-group-item list-group-item-action">Tous les documents</a>
                                <a href="{{ url('/documents/create') }}" class="list-group-item list-group-item-action">Créer un document</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection