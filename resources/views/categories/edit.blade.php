@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Categories</h1>
                <h2 class="text-muted">Modifier la catégorie {{ $category->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Modifier une catégorie</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/categories/{$category->id}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom de la catégorie</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $errors->has('name') ? old('name') : $category->name }}" placeholder="e.g. Catégorie" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <button class="btn btn-block btn-primary" type="submit">Mettre à jour</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
