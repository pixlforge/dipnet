@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
  <div class="recovery__container recovery__container--orange">
    <div class="recovery__panel">
      <h1 class="form__title">Réinitialiser le mot de passe</h1>

      @if (session('status'))
        <div class="alert alert--success">
          <i class="fal fa-check-circle"></i>
          <p>{{ session('status') }}</p>
          <p>
            <i class="fal fa-arrow-left alert__icon--back"></i>
            <a
              href="{{ route('index') }}"
              class="alert__link">
              Retour
            </a>
          </p>
        </div>
      @endif

      <form
        method="POST"
        action="{{ route('password.email') }}"
        role="form">
        @csrf

        <div class="form__group">
          <label
            for="email"
            class="form__label">
            Email
          </label>
          <span class="form__required">*</span>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            class="form__input"
            required
            autofocus>
          @if ($errors->has('email'))
            <div class="form__alert">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>

        <button
          type="submit"
          role="button"
          class="button__primary button__primary--red btn__primary--long">
          Réinitialiser le mot de passe
        </button>
      </form>
    </div>
  </div>
@endsection
