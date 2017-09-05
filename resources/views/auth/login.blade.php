@extends ('layouts.app')

@section ('title', 'Connexion à votre compte')

@section ('content')

    @include('layouts.company-logo')

    <div class="container-fluid">
        <div class="row">

            {{--Carousel pan--}}
            <div class="col-xs-12 col-lg-6 push-lg-6 fixed-lg-right no-padding">

                <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">

                        {{--Slide red--}}
                        <div class="carousel-item bg-red active">
                            <div class="carousel-slide carousel-slide-first d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                                <div class="carousel-slide-content text-center">
                                    <p class="lead">De nouvelles opportunités pour collaborer</p>
                                    <p class="description">Un moyen facile pour gérer vos fichiers et vos commandes. Groupez et envoyez vos commandes où vous le voulez.</p>
                                </div>
                            </div>
                        </div>

                        {{--Slide purple--}}
                        <div class="carousel-item bg-purple">
                            <div class="carousel-slide carousel-slide-second d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                                <div class="carousel-slide-content text-center">
                                    <p class="lead">Gérez vos commandes</p>
                                    <p class="description">Personnalisez vos commandes de manière individuelle, choisissez le type de papier et la qualité de l'impression, lieu de livraison, etc.</p>
                                </div>
                            </div>
                        </div>

                        {{--Slide orange--}}
                        <div class="carousel-item bg-orange">
                            <div class="carousel-slide carousel-slide-third d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                                <div class="carousel-slide-content text-center">
                                    <p class="lead">Vérifiez le statut de vos commandes</p>
                                    <p class="description">Vérifier l'avancement de vos commandes est un jeu d'enfant.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--Login pan--}}
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
                            <p class="text-small text-center">Pas encore enregistré? <a href="{{ route('register') }}" class="ml-3">Enregistrez-vous</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
