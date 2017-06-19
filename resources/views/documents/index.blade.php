@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Documents</h1>
                <h2 class="text-muted">Liste de touts les documents</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">
                    Il existe actuellement <strong>{{ $documents->count() }}</strong> {{ str_plural('document', $documents->count()) }} au total.
                </p>
                <div class="text-center mb-5">
                    <a href="{{ url('/documents/create') }}" class="btn btn-primary disabled">Ajouter</a>
                </div>
                <div class="card-columns">
                    @foreach ($documents as $document)
                        <div class="card">
                            <div class="card-block">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        @unless ($document->deleted_at === null)
                                            <i class="fa fa-trash text-danger"></i>
                                        @else
                                            <i class="fa fa-check text-success"></i>
                                        @endunless
                                    </h3>
                                    <div class="dropdown">
                                        <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item"
                                               href="{{ url("/documents/{$document->id}/edit") }}">
                                                <i class="fa fa-pencil"></i>
                                                <span class="ml-3">Modifier</span>
                                            </a>
                                            <form method="POST" action="{{ url("/documents/{$document->id}") }}">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                    <span class="ml-3">Supprimer</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-unstyled">

                                    {{--Name--}}
                                    <li class="mt-2 mb-4">
                                        <i class="fa fa-file-o fa-2x mr-3"></i>
                                        <span class="h2">{{ $document->file_name }}</span>
                                    </li>

                                    {{--File path--}}
                                    <li class="my-4">
                                        <h5>Chemin</h5>
                                        <i class="fa fa-search fa-lg mr-3"></i>
                                        <span>{{ $document->file_path }}</span><br>
                                    </li>

                                    {{--Mime type--}}
                                    <li class="my-4">
                                        <h5>Mime type</h5>
                                        <i class="fa fa-gear fa-lg mr-3"></i>
                                        <span>{{ $document->mime_type }}</span><br>
                                    </li>

                                    {{--Quantity--}}
                                    <li class="my-4">
                                        <h5>Quantité</h5>
                                        <i class="fa fa-plus fa-lg mr-3"></i>
                                        <span>{{ $document->quantity }}</span><br>
                                    </li>

                                    {{--Rolled folded flat--}}
                                    <li class="my-4">
                                        <h5>Roulé / plié / à plat</h5>
                                        <i class="fa fa-map fa-lg mr-3"></i>
                                        <span class="text-capitalize">{{ $document->rolled_folded_flat }}</span><br>
                                    </li>

                                    {{--Length--}}
                                    <li class="my-4">
                                        <h5>Hauteur</h5>
                                        <i class="fa fa-arrows-v fa-lg mr-3"></i>
                                        <span>{{ $document->length }}</span><br>
                                    </li>

                                    {{--Width--}}
                                    <li class="my-4">
                                        <h5>Largeur</h5>
                                        <i class="fa fa-arrows-h fa-lg mr-3"></i>
                                        <span>{{ $document->width }}</span><br>
                                    </li>

                                    {{--Nb orig--}}
                                    <li class="my-4">
                                        <h5>Nombre d'originaux</h5>
                                        <i class="fa fa-certificate fa-lg mr-3"></i>
                                        <span>{{ $document->nb_orig }}</span><br>
                                    </li>

                                    {{--Free--}}
                                    <li class="my-4">
                                        <h5>Gratuit</h5>
                                        <i class="fa fa-flash fa-lg mr-3"></i>
                                        <span>{{ $document->free }}</span><br>
                                    </li>

                                    {{--Format--}}
                                    <li class="my-4">
                                        <h5>Format</h5>
                                        <i class="fa fa-file-code-o fa-lg mr-3"></i>
                                        <span>{{ $document->format->name }}</span><br>
                                    </li>

                                    {{--Delivery--}}
                                    @isset ($document->delivery)
                                        <li class="my-4">
                                            <h5>Livraison</h5>
                                            <i class="fa fa-truck fa-lg mr-3"></i>
                                            <span>{{ $document->delivery->id }}</span><br>
                                        </li>
                                    @endisset

                                    {{--Article--}}
                                    <li class="my-4">
                                        <h5>Article</h5>
                                        <i class="fa fa-barcode fa-lg mr-3"></i>
                                        <span>{{ $document->article->reference }}</span><br>
                                    </li>

                                    {{--Created at--}}
                                    <li class="my-4">
                                        <h5>Date de création</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-check-o mr-3"></i>
                                                <span>{{ $document->created_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $document->created_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>

                                    {{--Modified at--}}
                                    <li class="my-4">
                                        <h5>Dernière modification</h5>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <i class="fa fa-calendar-plus-o mr-3"></i>
                                                <span>{{ $document->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <span><small>{{ $document->updated_at->diffForHumans() }}</small></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection