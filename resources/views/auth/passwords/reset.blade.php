@extends ('layouts.app')

@section ('title', 'Réinitialisation du mot de passe')

@section ('content')
  <div class="recovery__container recovery__container--purple">
    <div class="recovery__panel">
      <h1 class="form__title">Réinitialiser le mot de passe</h1>

      @if (session('status'))
        <div class="alert alert--success">
          <i class="fal fa-check-circle"></i>
          {{ session('status') }}
        </div>
      @endif

      <form
        method="POST"
        action="{{ route('password.request') }}"
        role="form">
        @csrf

        <input
          type="hidden"
          name="token"
          value="{{ $token }}">

        <div class="form__group">
          <label
            for="email"
            class="form__label">
            E-mail
          </label>
          <span class="form__required">*</span>
          <input
            type="email"
            id="email"
            name="email"
            class="form__input"
            value="{{ $email or old('email') }}"
            required
            autofocus>
          @if ($errors->has('email'))
            <div class="form__alert">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>

        <div class="form__group">
          <label
            for="password"
            class="form__label">
            Mot de passe
          </label>
          <span class="form__required">*</span>
          <input
            type="password"
            name="password"
            id="password"
            class="form__input"
            required>
          @if ($errors->has('password'))
            <div class="form__alert">
              {{ $errors->first('password') }}
            </div>
          @endif
        </div>

        <div class="form__group">
          <label
            for="password_confirmation"
            class="form__label">
            Confirmer le mot de passe
          </label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form__input"
            required>
          @if ($errors->has('password_confirmation'))
            <div class="form__alert">
              {{ $errors->first('password_confirmation') }}
            </div>
          @endif
        </div>

        <button
          type="submit"
          role="button"
          class="btn btn--red">
          Réinitialiser le mot de passe
        </button>
      </form>
    </div>
  </div>
@endsection
