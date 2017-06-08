@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col intro d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-1">Users</h1>
                <h2 class="text-muted">Modifier l'utilisateur {{ $user->username }}</h2>
            </div>
        </div>
    </div>

@endsection
