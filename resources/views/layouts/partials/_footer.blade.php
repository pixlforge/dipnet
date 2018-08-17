<div class="footer__container">
  <p>
    <i class="fal fa-copyright"></i>
    {{ now()->format('Y') }}
    <a href="{{ route('index') }}">{{ config('app.name') }}</a>.
    Tous droits réservés.
  </p>
</div>