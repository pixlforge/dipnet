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

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Confirmation du mot de passe</label>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary mt-2">S'enregistrer</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
