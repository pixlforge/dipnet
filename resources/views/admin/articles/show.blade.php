@extends('layouts.app')

@section('title', 'Détails pour l\'article "' . $article->reference . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-article :article="{{ $article }}"></show-article>
  @include('layouts.partials._footer')
@endsection