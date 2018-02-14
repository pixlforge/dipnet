@extends ('layouts.app')

@section ('title', 'Complétez les informations sur la société')

@section ('content')

  <app-account-company data-app-name="{{ config('app.name') }}"></app-account-company>

@endsection