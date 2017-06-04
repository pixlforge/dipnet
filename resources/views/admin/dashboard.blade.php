@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="display-1 text-center my-5">Dashboard</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card-columns">

                    {{--Formats--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Formats</h4>
                            <div class="list-group">
                                <a href="{{ url('/formats') }}" class="list-group-item list-group-item-action">Formats index</a>
                                <a href="{{ url('/formats/create') }}" class="list-group-item list-group-item-action">Formats create</a>
                                <a href="{{ url('/formats/format-id') }}" class="list-group-item list-group-item-action">Formats show</a>
                                <a href="{{ url('/formats/format-id/edit') }}" class="list-group-item list-group-item-action">Formats edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Compagnies--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Companies</h4>
                            <div class="list-group">
                                <a href="{{ url('/companies') }}" class="list-group-item list-group-item-action">Companies index</a>
                                <a href="{{ url('/companies/create') }}" class="list-group-item list-group-item-action">Companies create</a>
                                <a href="{{ url('/companies/company-id') }}" class="list-group-item list-group-item-action">Companies show</a>
                                <a href="{{ url('/companies/company-id/edit') }}" class="list-group-item list-group-item-action">Companies edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Categories--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Categories</h4>
                            <div class="list-group">
                                <a href="{{ url('/categories') }}" class="list-group-item list-group-item-action">Categories index</a>
                                <a href="{{ url('/categories/create') }}" class="list-group-item list-group-item-action">Categories create</a>
                                <a href="{{ url('/categories/category-id') }}" class="list-group-item list-group-item-action">Categories show</a>
                                <a href="{{ url('/categories/category-id/edit') }}" class="list-group-item list-group-item-action">Categories edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Businesses--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Businesses</h4>
                            <div class="list-group">
                                <a href="{{ url('/businesses') }}" class="list-group-item list-group-item-action">Businesses index</a>
                                <a href="{{ url('/businesses/create') }}" class="list-group-item list-group-item-action">Businesses create</a>
                                <a href="{{ url('/businesses/business-id') }}" class="list-group-item list-group-item-action">Businesses show</a>
                                <a href="{{ url('/businesses/business-id/edit') }}" class="list-group-item list-group-item-action">Businesses edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Articles--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Articles</h4>
                            <div class="list-group">
                                <a href="{{ url('/articles') }}" class="list-group-item list-group-item-action">Articles index</a>
                                <a href="{{ url('/articles/create') }}" class="list-group-item list-group-item-action">Articles create</a>
                                <a href="{{ url('/articles/article-id') }}" class="list-group-item list-group-item-action">Articles show</a>
                                <a href="{{ url('/articles/article-id/edit') }}" class="list-group-item list-group-item-action">Articles edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Contacts--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Contacts</h4>
                            <div class="list-group">
                                <a href="{{ url('/contacts') }}" class="list-group-item list-group-item-action">Contacts index</a>
                                <a href="{{ url('/contacts/create') }}" class="list-group-item list-group-item-action">Contacts create</a>
                                <a href="{{ url('/contacts/contact-id') }}" class="list-group-item list-group-item-action">Contacts show</a>
                                <a href="{{ url('/contacts/contact-id/edit') }}" class="list-group-item list-group-item-action">Contacts edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Orders--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Orders</h4>
                            <div class="list-group">
                                <a href="{{ url('/orders') }}" class="list-group-item list-group-item-action">Orders index</a>
                                <a href="{{ url('/orders/create') }}" class="list-group-item list-group-item-action">Orders create</a>
                                <a href="{{ url('/orders/order-id') }}" class="list-group-item list-group-item-action">Orders show</a>
                                <a href="{{ url('/orders/order-id/edit') }}" class="list-group-item list-group-item-action">Orders edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Deliveries--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Deliveries</h4>
                            <div class="list-group">
                                <a href="{{ url('/deliveries') }}" class="list-group-item list-group-item-action">Deliveries index</a>
                                <a href="{{ url('/deliveries/create') }}" class="list-group-item list-group-item-action">Deliveries create</a>
                                <a href="{{ url('/deliveries/delivery-id') }}" class="list-group-item list-group-item-action">Deliveries show</a>
                                <a href="{{ url('/deliveries/delivery-id/edit') }}" class="list-group-item list-group-item-action">Deliveries edit</a>
                            </div>
                        </div>
                    </div>

                    {{--Documents--}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Documents</h4>
                            <div class="list-group">
                                <a href="{{ url('/documents') }}" class="list-group-item list-group-item-action">Document index</a>
                                <a href="{{ url('/documents/create') }}" class="list-group-item list-group-item-action">Document create</a>
                                <a href="{{ url('/documents/document-id') }}" class="list-group-item list-group-item-action">Document show</a>
                                <a href="{{ url('/documents/document-id/edit') }}" class="list-group-item list-group-item-action">Document edit</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection