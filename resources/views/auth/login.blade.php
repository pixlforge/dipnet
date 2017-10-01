@extends ('layouts.app')

@section ('title', 'Connexion à votre compte')

@section ('content')

    @include('layouts.partials._company-logo')

    <div class="container-fluid">
        <div class="row">

            @include ('auth.partials._carousel')

            <div class="col-xs-12 col-lg-6 vh-100 d-flex align-items-center">
                <div class="col-xs-12 col-lg-8 offset-lg-2">

                    <form method="POST" action="{{ route('login') }}" role="form">
                        {{ csrf_field() }}

                        {{--Login section--}}
                        <h4 class="text-center">Connexion</h4>

                        {{--Email--}}
                        <div class="form-group my-5{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{--Password--}}
                        <div class="form-group my-5{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se rappeler
                            </label>
                        </div>

                        <div class="form-group">

                            {{--Submit--}}
                            <button type="submit" class="btn btn-black btn-block mt-5">Connexion</button>

                            {{--Forgot password--}}
                            <p class="text-small text-center mt-5"><a href="{{ route('password.request') }}" class="ml-3">Mot de passe oublié?</a></p>

                            {{--Register CTA--}}
                            <p class="text-small text-center">Pas encore enregistré? <a href="{{ route('register.index') }}" class="ml-3">Enregistrez-vous</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
