@extends ('layouts.app')

@section ('title', 'Utilisateurs')

@section ('content')
  @include ('layouts.partials._nav')
  <users :companies="{{ $companies }}"></users>
@endsection