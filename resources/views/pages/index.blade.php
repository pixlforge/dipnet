@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col intro d-flex justify-content-center align-items-center">
                <h1 class="display-1">{{ env('APP_NAME') }}</h1>
            </div>
        </div>
    </div>

@endsection