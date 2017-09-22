@extends ('layouts.app')

@section ('title', 'Articles')

@section ('content')

    @include ('layouts.nav')

    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-12 text-center my-5">--}}
                {{--<h1 class="display-1">Articles</h1>--}}
                {{--<h2 class="text-muted">Liste de tous les articles</h2>--}}
            {{--</div>--}}
            {{--<div class="col-12">--}}
                {{--<p class="text-center mb-5">--}}
                    {{----}}
                {{--</p>--}}
                {{--<div class="text-center mb-5">--}}
                    {{--<a href="{{ url('/articles/create') }}" class="btn btn-primary">Ajouter</a>--}}
                {{--</div>--}}
                {{--<div class="card-columns">--}}
                    {{--@foreach ($articles as $article)--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-block">--}}
                                {{--<div class="d-flex justify-content-between">--}}
                                    {{--<h3 class="card-title">--}}
                                        {{--@unless ($article->deleted_at === null)--}}
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
                                            {{--@unless ($article->deleted_at === null)--}}
                                                {{--<form method="POST"--}}
                                                      {{--action="{{ url("/articles/{$article->reference}/restore") }}">--}}
                                                    {{--{{ method_field('PUT') }}--}}
                                                    {{--{{ csrf_field() }}--}}

                                                    {{--<button class="dropdown-item text-success" type="submit">--}}
                                                        {{--<i class="fa fa-refresh"></i>--}}
                                                        {{--<span class="ml-3">Restaurer</span>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<a class="dropdown-item"--}}
                                                   {{--href="{{ url("/articles/{$article->reference}/edit") }}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--<span class="ml-3">Modifier</span>--}}
                                                {{--</a>--}}
                                                {{--<form method="POST"--}}
                                                      {{--action="{{ url("/articles/{$article->reference}") }}">--}}
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

                                    {{--Name--}}
                                    {{--<li class="mt-2 mb-4">--}}
                                        {{--<h2><i class="fa fa-barcode mr-2"></i> {{ $article->reference }}</h2>--}}
                                    {{--</li>--}}

                                    {{--Description--}}
                                    {{--@isset ($article->description)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-comment mr-2"></i> Description</h5>--}}
                                            {{--<span>{{ $article->description }}</span>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--Type--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-cog mr-2"></i> Type</h5>--}}
                                        {{--<span class="text-capitalize">{{ $article->type }}</span>--}}
                                    {{--</li>--}}

                                    {{--Category--}}
                                    {{--@isset ($article->category->name)--}}
                                        {{--<li class="my-4">--}}
                                            {{--<h5><i class="fa fa-tag mr-2"></i> Catégorie</h5>--}}
                                            {{--<span>{{ $article->category->name }}</span>--}}
                                        {{--</li>--}}
                                    {{--@endisset--}}

                                    {{--Created at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-check-o mr-2"></i> Date de création</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $article->created_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $article->created_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Modified at--}}
                                    {{--<li class="my-4">--}}
                                        {{--<h5><i class="fa fa-calendar-plus-o mr-2"></i> Dernière modification</h5>--}}
                                        {{--<div class="d-flex flex-row justify-content-between">--}}
                                            {{--<span>{{ $article->updated_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                            {{--<span><small>{{ $article->updated_at->diffForHumans() }}</small></span>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--Deleted at--}}
                                    {{--@unless($article->deleted_at === null)--}}
                                        {{--<li class="my-4 text-danger">--}}
                                            {{--<h5><i class="fa fa-trash mr-2"></i> Date de suppression</h5>--}}
                                            {{--<div class="d-flex flex-row justify-content-between">--}}
                                                {{--<span>{{ $article->deleted_at->formatLocalized('%A %d %B %Y') }}</span>--}}
                                                {{--<span><small>{{ $article->deleted_at->diffForHumans() }}</small></span>--}}
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