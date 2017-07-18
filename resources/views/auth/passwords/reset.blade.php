@extends('layouts.app')

@section('content')

<div class="container-fluid bg-shapes-red">
    <div class="row vh-100">
        <div class="col-xs-12 col-lg-10 mx-auto align-self-center">
            <div class="card align-self-center">
                <div class="card-block">
                    <h4 class="card-title text-center my-5">Réinitialiser le mot de passe</h4>

                    <div class="col-xs-12 col-lg-10 mx-auto">

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.request') }}" role="form" class="my-5">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group my-5{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $email or old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group my-5{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Mot de passe</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group my-5{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group my-5">

                                {{--Submit--}}
                                <button type="submit" class="btn btn-black btn-block mt-5">
                                    Réinitialiser le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
