@extends ('layouts.app')

@include ('layouts.nav')

@section ('title', 'Livraisons')

@section ('content')

    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-12 text-center my-5">--}}
                {{--<h1 class="display-1">Deliveries</h1>--}}
                {{--<h2 class="text-muted">Liste de toutes les livraisons</h2>--}}
            {{--</div>--}}
            {{--<div class="col-12">--}}
                {{--<p class="text-center mb-5">--}}
                    {{--Il existe actuellement <strong>{{ $deliveries->count() }}</strong> {{ str_plural('livraison', $deliveries->count()) }} au total.--}}
                {{--</p>--}}
                {{--<div class="text-center mb-5">--}}
                    {{--<a href="{{ url('/deliveries/create') }}" class="btn btn-primary">Ajouter</a>--}}
                {{--</div>--}}
                {{--<div class="card-columns">--}}
                    {{--@foreach ($deliveries as $delivery)--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-block">--}}
                                {{--<div class="d-flex justify-content-between">--}}
                                    {{--<h3 class="card-title">--}}
                                        {{--@unless ($delivery->deleted_at === null)--}}
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
                                            {{--@unless ($delivery->deleted_at === null)--}}
                                                {{--<form method="POST"--}}
                                                      {{--action="{{ url("/deliveries/{$delivery->id}/restore") }}">--}}
                                                    {{--{{ method_field('PUT') }}--}}
                                                    {{--{{ csrf_field() }}--}}

                                                    {{--<button class="dropdown-item text-success" type="submit">--}}
                                                        {{--<i class="fa fa-refresh"></i>--}}
                                                        {{--<span class="ml-3">Restaurer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<a class="dropdown-item"--}}
                                                   {{--href="{{ url("/deliveries/{$delivery->id}/edit") }}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--<span class="ml-3">Modifier</span>--}}
                                                {{--</a>--}}
                                                {{--<form method="POST" action="{{ url("/deliveries/{$delivery->id}") }}">--}}
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

                                    {{--Id--}}
                                    {{--<li class="mt-2 mb-4">--}}
                                        {{--<h2><i class="fa fa-truck mr-2"></i> {{ $delivery->id}}</h2>--}}
                                    {{--</li>--}}

                                    {{--@isset ($delivery->internal_comment)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-comment mr-2"></i> Commentaire</h5>--}}
                                            {{--<span>{{ $delivery->internal_comment }}</span>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--Order--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-shopping-cart mr-2"></i> Commande</h5>--}}
                                        {{--<span>{{ $delivery->order->reference }}</span>--}}
                                    {{--</li>--}}

                                    {{--Contact--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-address-card mr-2"></i> Contact</h5>--}}
                                        {{--<span>{{ $delivery->contact->name }}</span>--}}
                                    {{--</li>--}}

                                    {{--Created at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $delivery->created_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $delivery->created_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Modified at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $delivery->updated_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $delivery->updated_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Deleted at--}}
                                    {{--@unless($delivery->deleted_at === null)--}}
                                        {{--<li class="my-4 text-danger">--}}
                                            {{--<h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $delivery->deleted_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $delivery->deleted_at->diffForHumans() }}</small></span>--}}
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