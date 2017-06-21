@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Users</h1>
                <h2 class="text-muted">Ajouter un nouvel utilisateur</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h2 class="text-center my-5">Ajouter un utilisateur</h2>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url('/users') }}" role="form">
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

                                {{--Email--}}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. votre@email.ch" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Role--}}
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="role">Rôle</label>
                                    <select name="role" id="role" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un role</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        <option value="utilisateur" {{ old('role') == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                                        <option value="administrateur" {{ old('role') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
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

                                {{--Confirmation--}}
                                <div class="form-group">
                                    <label for="password-confirm">Confirmation du mot de passe</label>
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Répétez votre mot de passe" required>
                                </div>

                                {{--Submit--}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Ajouter</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
