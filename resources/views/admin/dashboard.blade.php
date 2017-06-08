@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="display-1 text-center my-5">Dashboard</h1>
            </div>
            <div class="col-12">
                <div class="card-columns">

                    {{--Users--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Utilisateurs</h4>
                            <div class="list-group">
                                <a href="{{ route('users') }}" class="list-group-item list-group-item-action">Tous les utilisateurs</a>
                                <a href="{{ url('/users/create') }}" class="list-group-item list-group-item-action">Nouvel utilisateur</a>
                            </div>
                        </div>
                    </div>

                    {{--Formats--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Formats</h4>
                            <div class="list-group">
                                <a href="{{ route('formats') }}" class="list-group-item list-group-item-action">Tous les formats</a>
                                <a href="{{ url('/formats/create') }}" class="list-group-item list-group-item-action">Nouveau format</a>
                            </div>
                        </div>
                    </div>

                    {{--Compagnies--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Sociétés</h4>
                            <div class="list-group">
                                <a href="{{ route('companies') }}" class="list-group-item list-group-item-action">Toutes les sociétés</a>
                                <a href="{{ url('/companies/create') }}" class="list-group-item list-group-item-action">Nouvelle société</a>
                            </div>
                        </div>
                    </div>

                    {{--Categories--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Catégories</h4>
                            <div class="list-group">
                                <a href="{{ route('categories') }}" class="list-group-item list-group-item-action">Toutes les catégories</a>
                                <a href="{{ url('/categories/create') }}" class="list-group-item list-group-item-action">Nouvelle catégorie</a>
                            </div>
                        </div>
                    </div>

                    {{--Businesses--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Affaires</h4>
                            <div class="list-group">
                                <a href="{{ route('businesses') }}" class="list-group-item list-group-item-action">Toutes les affaires</a>
                                <a href="{{ url('/businesses/create') }}" class="list-group-item list-group-item-action">Nouvelle affaire</a>
                            </div>
                        </div>
                    </div>

                    {{--Articles--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Articles</h4>
                            <div class="list-group">
                                <a href="{{ route('articles') }}" class="list-group-item list-group-item-action">Tous les articles</a>
                                <a href="{{ url('/articles/create') }}" class="list-group-item list-group-item-action">Nouvel article</a>
                            </div>
                        </div>
                    </div>

                    {{--Contacts--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Contacts</h4>
                            <div class="list-group">
                                <a href="{{ route('contacts') }}" class="list-group-item list-group-item-action">Tous les contacts</a>
                                <a href="{{ url('/contacts/create') }}" class="list-group-item list-group-item-action">Nouveau contact</a>
                            </div>
                        </div>
                    </div>

                    {{--Orders--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Commandes</h4>
                            <div class="list-group">
                                <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">Toutes les commandes</a>
                                <a href="{{ url('/orders/create') }}" class="list-group-item list-group-item-action">Nouvelle commande</a>
                            </div>
                        </div>
                    </div>

                    {{--Deliveries--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Livraisons</h4>
                            <div class="list-group">
                                <a href="{{ route('deliveries') }}" class="list-group-item list-group-item-action">Toutes les livraisons</a>
                                <a href="{{ url('/deliveries/create') }}" class="list-group-item list-group-item-action">Nouvelle livraison</a>
                            </div>
                        </div>
                    </div>

                    {{--Documents--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Documents</h4>
                            <div class="list-group">
                                <a href="{{ route('documents') }}" class="list-group-item list-group-item-action">Tous les documents</a>
                                <a href="{{ url('/documents/create') }}" class="list-group-item list-group-item-action">Nouveau document</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection