@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Formats</h1>
                <h2 class="text-muted">Modifier le format {{ $format->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Modifier un format</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/formats/{$format->name}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom du format</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $errors->has('name') ? old('name') : $format->name }}" placeholder="e.g. A4" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4{{ $errors->has('height') ? ' has-error' : '' }}">
                                        <label for="height">Hauteur</label>
                                        <input type="number" id="height" name="height" class="form-control"
                                               value="{{ $errors->has('height') ? old('height') : $format->height }}" placeholder="e.g. 210(mm)" required>
                                        @if ($errors->has('height'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('height') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4{{ $errors->has('width') ? ' has-error' : '' }}">
                                        <label for="width">Largeur</label>
                                        <input type="number" id="width" name="width" class="form-control"
                                               value="{{ $errors->has('width') ? old('width') : $format->width }}" placeholder="e.g. 297(mm)" required>
                                        @if ($errors->has('width'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('width') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="col-xs-12 col-md-4{{ $errors->has('surface') ? ' has-error' : '' }}">
                                        <label for="surface">Surface</label>
                                        <input type="number" step="any" id="surface" name="surface" class="form-control"
                                               value="{{ $errors->has('surface') ? old('surface') : $format->surface }}" placeholder="e.g. 0.062(m2)">
                                        @if ($errors->has('surface'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('surface') }}</strong>
                                        </span>
                                        @endif
                                    </div>
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
