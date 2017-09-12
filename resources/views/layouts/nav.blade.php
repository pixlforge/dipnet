<header>

    <div class="container-fluid">
        <div class="col-10 mx-auto px-1">

            <nav class="navbar navbar-toggleable-md navbar-light">

                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false"
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
                                <img src="{{ asset('img/avatars/placeholder-girl.jpg') }}" alt="Avatar"
                                     class="menu-avatar"
                                     aria-hidden="true">
                            </li>
                            <li class="nav-item dropdown">
                                @include ('layouts.nav-links-dropdown')
                            </li>

                            <div class="divider mx-3"></div>

                            <li class="nav-item{{ Route::is('companies.show') ? ' active' : '' }}">
                                @if (auth()->user()->role === 'administrateur')
                                    <a href="{{ route('companies') }}" class="nav-link">
                                        {{ auth()->user()->company->name }}
                                    </a>
                                @endif

                                @if (auth()->user()->role === 'utilisateur')
                                    <a href="{{ route('companies.show', ['id' => auth()->user()->company_id]) }}" class="nav-link">
                                        {{ auth()->user()->company->name }}
                                    </a>
                                @endif

                                @if (Route::is('companies.show'))
                                    <span class="sr-only">(current)</span>
                                @endif
                            </li>


                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>