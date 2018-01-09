@extends ('layouts.app')

@section ('title', 'Livraisons')

@section ('content')

    @include ('layouts.partials._nav')

   <app-deliveries :data-deliveries="{{ $deliveries }}">
   </app-deliveries>

@endsection