@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Companies</h1>
                <h2 class="text-muted">Modifier la société {{ $company->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Modifier une société</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/companies/{$company->id}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                {{--Name--}}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom de la société</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $company->name }}" placeholder="e.g. Pantone" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Status--}}
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un status</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        <option value="temporaire" {{ $company->status == 'temporaire' ? 'selected' : '' }}>Temporaire</option>
                                        <option value="permanent" {{ $company->status == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Description--}}
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" class="form-control"
                                           value="{{ $company->description }}" placeholder="e.g. Courte description de la société">
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Submit--}}
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
