@include('layouts.nav')

@extends('layouts.app')

@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="row align-items-center">

                    {{--Page title--}}
                    <div class="col-xs-12 col-lg-7 center-on-small-only my-5 my-md-0">
                        <h1>Commandes</h1>
                    </div>

                    {{--Sorter--}}
                    <div class="col-xs-12 col-sm-6 col-lg-3 center-on-small-only ml-5 ml-sm-0">
                        <label for="businessSelect" class="light ml-4 ml-sm-0">Affaire</label>
                        <i class="fa fa-caret-down fa-select"></i>
                        <select name="businessSelect" id="businessSelect" class="custom-select">
                            <option selected>Tout</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->business->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--Button--}}
                    <div class="col-xs-12 col-sm-6 col-lg-2 center-on-small-only text-lg-right">
                        <a href="{{ url('/orders/create') }}" class="btn btn-lg btn-black">Nouvelle commande</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-grey-light">
        <div class="row">
            <div class="col-10 mx-auto my-7">

                @foreach ($orders as $order)
                    <div class="card card-custom">

                        {{--Image--}}
                        <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center hidden-md-down"
                             style="height: 80px;">
                            <i class="fa fa-file-pdf-o fa-3x"></i>
                        </div>

                        {{--Content--}}
                        <div class="col-12 col-lg-10 center-on-small-only justify-content-lg-between">
                            <div class="row align-items-center">

                                {{--Reference--}}
                                <div class="col-12 col-lg-5">
                                    <h5 class="m-0">
                                        {{ $order->reference }}
                                    </h5>
                                </div>

                                {{--Status--}}
                                <div class="col-12 col-lg-2 text-center">
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
                                <div class="col-12 col-lg-2">
                                    <span>
                                        {{ $order->created_at->formatLocalized('%d %B %Y') }}
                                    </span>
                                </div>

                                {{--Related business--}}
                                <div class="col-12 col-lg-3">
                                    <span>
                                        {{ $order->business->name }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
