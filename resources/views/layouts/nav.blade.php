<header>

    <div class="container-fluid">

        <nav class="navbar navbar-toggleable-md navbar-light">

                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Balancer la navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a href="{{ route('index') }}" class="navbar-brand">
                    @if (env('APP_NAME') == 'Dipnet')
                        <img src="{{ asset('img/logos/dip-logo.png') }}" alt="Dip logo" class="img-fluid">
                    @else
                        <img src="{{ asset('img/logos/multicop-logo.png') }}" alt="Multicop logo" class="img-fluid">
                    @endif
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        {{--Homepage--}}
                        <li class="nav-item">
                            <a href="{{ route('index') }}" class="nav-link">Accueil</a>
                        </li>

                        {{--Dashboard--}}
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>

                        {{--Account--}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::check())
                                    {{ Auth::user()->username }}
                                @else
                                    Compte
                                @endif
                            </a>
                            <div class="dropdown-menu">
                                @if (Auth::check())
                                    <a href="{{ url('logout') }}" class="dropdown-item">Déconnexion</a>
                                @else
                                    <a href="{{ route('login') }}" class="dropdown-item">Connexion</a>
                                    <a href="{{ route('register') }}" class="dropdown-item">Enregistrement</a>
                                @endif
                            </div>
                        </li>
                    </ul>

                    {{--Search form--}}
                    <form method="GET" action="" class="form-inline">
                        {{ csrf_field() }}
                        <input type="text" class="form-control form-control-sm mr-sm-2" placeholder="Rechercher">
                        <button class="btn btn-primary btn-sm my-2 my-sm-0" type="submit">Recherche</button>
                    </form>

                </div>

        </nav>

    </div>

</header>