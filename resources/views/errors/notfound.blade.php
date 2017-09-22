@extends ('layouts.app')

@section ('title', 'Page introuvable')

@section ('content')

    @include ('layouts.nav')

    <div class="container-fluid">
        <div class="row vh-80">
            <div class="col-12 col-lg-8 mx-auto text-center d-flex flex-column justify-content-center align-self-center">
                <div class="col-lg-2 mx-auto">
                    <img src="{{ asset('img/icons/search@3x.png') }}" alt="Recherche" class="img-fluid">
                </div>
                <h1 class="display-2 my-4">404</h1>
                <h1 class="light">
                    Désolé, la page demandée est introuvable.
                </h1>
            </div>
        </div>
    </div>

@endsection