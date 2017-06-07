@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Businesses</h1>
                <h2 class="text-muted">Ajouter une nouvelle affaire</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Ajouter une nouvelle affaire</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url('/businesses') }}" role="form">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom de l'affaire</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ old('name') }}" placeholder="e.g. Fête du Printemps" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                    <label for="reference">Référence</label>
                                    <input type="text" id="reference" name="reference" class="form-control"
                                           value="{{ old('reference') }}" placeholder="e.g. E456RFG12D0" required>
                                    @if ($errors->has('reference'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" class="form-control"
                                           value="{{ old('description') }}" placeholder="e.g. Lorem ipsum dolor sit amet." required>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div>
                                    <h3>TODO</h3>
                                    <p>Select company</p>
                                    <p>Select contact</p>
                                </div>

                                <div class="form-group mt-4">
                                    <button class="btn btn-block btn-primary" type="submit">Créer</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
