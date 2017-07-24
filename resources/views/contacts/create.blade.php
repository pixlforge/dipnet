@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Contacts</h1>
                <h2 class="text-muted">Ajouter un nouveau contact</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Ajouter un contact</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url('/contacts') }}" role="form">
                                {{ csrf_field() }}

                                {{--Name--}}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nom de contact</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ old('name') }}" placeholder="Nom du contact" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Address line 1--}}
                                <div class="form-group{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                    <label for="address_line1">Adresse ligne 1</label>
                                    <input type="text" id="address_line1" name="address_line1" class="form-control"
                                           value="{{ old('address_line1') }}" placeholder="Rue, n°" required>
                                    @if ($errors->has('address_line1'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_line1') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Address line 2--}}
                                <div class="form-group{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                    <label for="address_line2">Adresse ligne 2</label>
                                    <input type="text" id="address_line2" name="address_line2" class="form-control"
                                           value="{{ old('address_line2') }}" placeholder="Appartement, suite">
                                    @if ($errors->has('address_line2'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_line2') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="row form-group">
                                    {{--Zip--}}
                                    <div class="col-xs-12 col-sm-4{{ $errors->has('zip') ? ' has-error' : '' }}">
                                        <label for="zip">Code postal</label>
                                        <input type="text" id="zip" name="zip" class="form-control"
                                               value="{{ old('zip') }}" placeholder="e.g. 1002" required>
                                        @if ($errors->has('zip'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    {{--City--}}
                                    <div class="col-xs-12 col-sm-8{{ $errors->has('city') ? ' has-error' : '' }}">
                                        <label for="city">Ville</label>
                                        <input type="text" id="city" name="city" class="form-control"
                                               value="{{ old('city') }}" placeholder="e.g. Lausanne" required>
                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row form-group">
                                    {{--Phone--}}
                                    <div class="col-xs-12 col-sm-6{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                        <label for="phone_number">Téléphone</label>
                                        <input type="text" id="phone_number" name="phone_number" class="form-control"
                                               value="{{ old('phone_number') }}" placeholder="e.g. +41 (0)12 345 67 89">
                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    {{--Fax--}}
                                    <div class="col-xs-12 col-sm-6{{ $errors->has('fax') ? ' has-error' : '' }}">
                                        <label for="fax">Fax</label>
                                        <input type="text" id="fax" name="fax" class="form-control"
                                               value="{{ old('fax') }}" placeholder="e.g. +41 (0)12 345 67 90">
                                        @if ($errors->has('fax'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('fax') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                {{--Email--}}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                           value="{{ old('email') }}" placeholder="e.g. votre@email.ch" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Company--}}
                                <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                                    <label for="company_id">Société</label>
                                    <select name="company_id" id="company_id" class="custom-select form-control">
                                        <option selected>Sélectionnez une société</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
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

                                {{--Submit--}}
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
