@extends ('layouts.app')

@section ('title', 'Utilisateurs')

@section ('content')

  @include ('layouts.partials._nav')

  <app-users :data-companies="{{ $companies }}"></app-users>

@endsection