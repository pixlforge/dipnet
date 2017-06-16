@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Businesses</h1>
                <h2 class="text-muted">Modifier l'affaire {{ $business->name }}</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Modifier une affaire</h4>
                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/businesses/{$business->id}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                {{--Name--}}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom de l'affaire</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $business->name }}" placeholder="e.g. Fête du Printemps" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Reference--}}
                                <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                    <label for="reference">Référence</label>
                                    <input type="text" id="reference" name="reference" class="form-control"
                                           value="{{ $business->reference }}" placeholder="e.g. E456RFG12D0" required>
                                    @if ($errors->has('reference'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Description--}}
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" class="form-control"
                                           value="{{ $business->description }}" placeholder="e.g. Lorem ipsum dolor sit amet.">
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Company--}}
                                <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                                    <label for="company_id">Société</label>
                                    <select name="company_id" id="company_id" class="custom-select form-control">
                                        <option disabled selected>Sélectionnez une société</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($companies as $company)
                                            <option value="{{ $company->id }}" {{ $business->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                        @empty
                                            <option disabled>Aucune société trouvée</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Contact--}}
                                <div class="form-group{{ $errors->has('contact_id') ? ' has-error' : '' }}">
                                    <label for="contact_id">Contact</label>
                                    <select name="contact_id" id="contact_id" class="custom-select form-control">
                                        <option disabled selected>Sélectionnez un contact</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ $business->contact_id == $contact->id ? 'selected' : '' }}>{{ "{$contact->company->name} / {$contact->name}" }}</option>
                                        @empty
                                            <option disabled>Aucun contact trouvé</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('contact_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('contact_id') }}</strong>
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