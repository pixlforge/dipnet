@include('layouts.nav')

@extends('layouts.app')

@section('content')


    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="row align-items-center">

                    {{--Page title--}}
                    <div class="col-7">
                        <h1>Commandes</h1>
                    </div>

                    {{--Sorter--}}
                    <div class="col-3">
                        <label for="businessSelect" class="light">Business</label>
                        <select name="businessSelect" id="businessSelect" class="custom-select">
                            <option selected>Tout</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <i class="fa fa-caret-down fa-select"></i>
                    </div>

                    {{--Button--}}
                    <div class="col-2">
                        <a href="{{ url('/orders/create') }}" class="btn btn-lg btn-black">Nouvelle commande</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-grey-light">
        <div class="row">
            <div class="col-10 mx-auto my-7">

                @foreach($orders as $order)
                    <div class="card card-custom">

                        {{--Image--}}
                        <div class="col-2 d-flex justify-content-center align-items-center" style="height: 80px;">
                            <i class="fa fa-file-pdf-o fa-3x"></i>
                        </div>

                        {{--Infos--}}
                        <div class="col-10 d-flex justify-content-between align-items-center">

                            {{--Reference--}}
                            <div class="col-4">
                                <h5>
                                    {{ $order->reference }}
                                </h5>
                            </div>

                            {{--Status--}}
                            <div class="col-3 text-center">
                                @if ($order->status == 'ok')
                                    <span class="badge badge-custom badge-success">
                                        Completed
                                    </span>
                                @else
                                    <span class="badge badge-custom badge-warning">
                                        Pending...
                                    </span>
                                @endif
                            </div>

                            {{--Date--}}
                            <div class="col-2">
                                <span>
                                    {{ $order->created_at->formatLocalized('%d %B %Y') }}
                                </span>
                            </div>

                            {{--Related business--}}
                            <div class="col-4">
                                <span class="ml-3">
                                    {{ $order->business->name }}
                                </span>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    {{--<div class="container-fluid bg-grey-light">--}}
        {{--<div class="row">--}}
            {{--<div class="col-11 mx-auto my-7">--}}
                {{--<div class="card-columns">--}}
                    {{--@foreach ($orders as $order)--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-block">--}}
                                {{--<div class="d-flex justify-content-between">--}}
                                    {{--<h3 class="card-title">--}}
                                        {{--@unless ($order->deleted_at === null)--}}
                                            {{--<i class="fa fa-trash text-danger"></i>--}}
                                        {{--@else--}}
                                            {{--<i class="fa fa-check text-success"></i>--}}
                                        {{--@endunless--}}
                                    {{--</h3>--}}

                                    {{--<div class="dropdown">--}}
                                        {{--<a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"--}}
                                           {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                            {{--<i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
                                        {{--<div class="dropdown-menu dropdown-menu-right"--}}
                                             {{--aria-labelledby="dropdownMenuLink">--}}
                                            {{--@unless ($order->deleted_at === null)--}}
                                                {{--<form method="POST" action="{{ url("/orders/{$order->id}/restore") }}">--}}
                                                    {{--{{ method_field('PUT') }}--}}
                                                    {{--{{ csrf_field() }}--}}

                                                    {{--<button class="dropdown-item text-success" type="submit">--}}
                                                        {{--<i class="fa fa-refresh"></i>--}}
                                                        {{--<span class="ml-3">Restaurer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<a class="dropdown-item" href="{{ url("/orders/{$order->id}/edit") }}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--<span class="ml-3">Modifier</span>--}}
                                                {{--</a>--}}
                                                {{--<form method="POST" action="{{ url("/orders/{$order->id}") }}">--}}
                                                    {{--{{ method_field('DELETE') }}--}}
                                                    {{--{{ csrf_field() }}--}}
                                                    {{--<button class="dropdown-item text-danger" type="submit">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                        {{--<span class="ml-3">Supprimer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@endunless--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                                {{--<ul class="list-unstyled">--}}

                                    {{--Reference--}}
                                    {{--<li class="mt-2 mb-4">--}}
                                        {{--<h2><i class="fa fa-shopping-cart mr-2"></i> {{ $order->reference }}</h2>--}}
                                    {{--</li>--}}

                                    {{--Status--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-bolt mr-2"></i> Status</h5>--}}
                                        {{--<span>{{ $order->status }}</span>--}}
                                    {{--</li>--}}

                                    {{--Business--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-handshake-o mr-2"></i> Affaire</h5>--}}
                                        {{--<span>{{ $order->business->name }}</span>--}}
                                    {{--</li>--}}

                                    {{--Contact--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-address-card mr-2"></i> Contact</h5>--}}
                                        {{--<span class="text-capitalize">{{ $order->contact->name }}</span>--}}
                                    {{--</li>--}}

                                    {{--Créé par--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-user mr-2"></i> Créé par</h5>--}}
                                        {{--<span>{{ $order->user->username }}</span>--}}
                                    {{--</li>--}}


                                    {{--Created at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $order->created_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $order->created_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Modified at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $order->updated_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $order->updated_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Deleted at--}}
                                    {{--@unless($order->deleted_at === null)--}}
                                        {{--<li class="my-4 text-danger">--}}
                                            {{--<h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $order->deleted_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $order->deleted_at->diffForHumans() }}</small></span>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endunless--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection
