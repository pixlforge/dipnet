@extends ('layouts.app')

@section ('title', 'Mot de passe oublié')

@section ('content')

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

                        <form method="POST" action="{{ route('password.email') }}" role="form" class="my-5">
                            {{ csrf_field() }}

                            <div class="form-group my-5{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-Mail Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
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
