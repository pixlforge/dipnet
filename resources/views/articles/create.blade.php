@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Articles</h1>
                <h2 class="text-muted">Ajouter un nouvel article</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Ajouter un article</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url('/articles') }}" role="form">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                    <label for="reference">Référence</label>
                                    <input type="text" id="reference" name="reference" class="form-control"
                                           value="{{ old('reference') }}" placeholder="A34F123.00" required autofocus>
                                    @if ($errors->has('reference'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" class="form-control"
                                           value="{{ old('description') }}" placeholder="Courte description...">
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un type</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        <option value="impression" {{ old('type') == 'impression' ? 'selected' : '' }}>Impression</option>
                                        <option value="option" {{ old('type') == 'option' ? 'selected' : '' }}>Option</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <label for="category">Catégorie</label>
                                    <select name="category" id="category" class="custom-select form-control" required>
                                        <option selected>Sélectionnez une catégorie</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @empty
                                            <option disabled>Aucune catégorie trouvée</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
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
