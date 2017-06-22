@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card mt-5">
                <div class="card-block">
                    <h1 class="card-title text-center mt-5">Enregistrement</h1>
                    <div class="col-8 offset-2">
                        <form method="POST" action="{{ route('register') }}" role="form" class="my-5">
                            {{ csrf_field() }}

                            {{--Username--}}
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" placeholder="e.g. John Doe" required autofocus>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--E-mail--}}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. votre@email.ch" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--Password--}}
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Entre 6 et 45 caractères" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--Password confirm--}}
                            <div class="form-group">
                                <label for="password-confirm">Confirmation du mot de passe</label>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Répétez votre mot de passe" required>
                            </div>

                            {{--Contact section--}}
                            <h2 class="card-title text-center my-5">Contact</h2>

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

                            {{--Company section--}}
                            <h2 class="card-title text-center mt-5">Société</h2>

                            <p class="text-center my-5">Bénéficiez de diverses options de paiement et de livraison en inscrivant le nom de votre société ou de votre entreprise dans le champ suivant.</p>

                            {{--Name--}}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">Société</label>
                                <input type="text" id="name" name="name" class="form-control"
                                       value="{{ old('name') }}" placeholder="e.g. Pantone">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Créer le compte</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
