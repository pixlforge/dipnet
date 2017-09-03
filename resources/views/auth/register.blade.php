@extends ('layouts.app')

@section ('title', 'Création de compte')

@section ('content')

    @include ('layouts.company-logo')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.carousel')
            <app-register></app-register>
        </div>
    </div>

@endsection
