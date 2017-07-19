<header>

    <div class="container-fluid">
        <div class="col-10 mx-auto px-1">

        <nav class="navbar navbar-toggleable-md navbar-light">

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Balancer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{--Logo--}}
            <a href="{{ route('index') }}">
                @if (env('APP_NAME') == 'Dipnet')
                    <img src="{{ asset('img/logos/dip-logo-md.png') }}" alt="Dip logo" class="nav-logo">
                @endif
                @if (env('APP_NAME') == 'Multicop')
                    <img src="{{ asset('img/logos/multicop-logo-md.png') }}" alt="Multicop logo"
                         class="nav-logo">
                @endif
            </a>


            <div class="collapse navbar-collapse pt-3 justify-content-between" id="navbarSupportedContent">

                {{--Search form--}}
                <div class="menu-item ml-lg-5">
                    <form method="POST" action="" class="form-inline form-nav">
                        {{ csrf_field() }}
                        <i class="fa fa-search "></i>
                        <input type="text" class="form-control" placeholder="Rechercher">
                    </form>
                </div>

                {{--Links--}}
                <div class="menu-item">
                    <ul class="navbar-nav">

                        {{--Orders--}}
                        <li class="nav-item{{ Route::is('index') ? ' active' : '' }}">
                            <a href="{{ route('index') }}" class="nav-link">
                                Commandes
                                @if (Route::is('index'))
                                    <span class="sr-only">(current)</span>
                                @endif
                            </a>
                        </li>

                        {{--Businesses--}}
                        <li class="nav-item mx-2{{ Route::is('businesses') ? ' active' : '' }}">
                            <a href="{{ route('businesses') }}" class="nav-link">
                                Affaires
                                @if (Route::is('businesses'))
                                    <span class="sr-only">(current)</span>
                                @endif
                            </a>
                        </li>

                        {{--Contacts--}}
                        <li class="nav-item{{ Route::is('contacts') ? ' active' : '' }}">
                            <a href="{{ route('contacts') }}" class="nav-link">
                                Contacts
                                @if (Route::is('contacts'))
                                    <span class="sr-only">(current)</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                {{--Account--}}
                <div class="menu-item">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <img src="{{ asset('img/avatars/placeholder-girl.jpg') }}" alt="Avatar" class="menu-avatar"
                                 aria-hidden="true">
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">
                                @if (Auth::check())
                                    {{ Auth::user()->username }}
                                @else
                                    <span>Compte</span>
                                @endif
                            </a>
                            <div class="dropdown-menu">
                                @if (Auth::check())
                                    <a href="{{ route('profile') }}" class="dropdown-item">
                                        Profil
                                    </a>
                                    <a href="{{ url('logout') }}" class="dropdown-item">
                                        Déconnexion
                                    </a>
                                @endif
                            </div>
                        </li>

                        <div class="divider mx-3"></div>

                        <li class="nav-item">
                            <a href="" class="nav-link">
                                {{ auth()->user()->company->name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        </div>
    </div>
</header>