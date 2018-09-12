@component('mail::message')
# Vérification de votre nouvelle adresse e-mail

Nous avons remarqué que vous aviez changé votre adresse e-mail.

Veuillez, s'il-vous-plaît, confirmer que vous êtes bien le propriétaire de cette nouvelle adresse e-mail en accédant à l'adresse ci-dessous à l'aide de votre navigateur ou en cliquant sur le bouton ci-dessous:

@component('mail::button', ['url' => route('register.confirm.index', ['token' => $user->confirmation_token]), 'color' => 'red'])
Confirmer ma nouvelle adresse e-mail
@endcomponent

Veuillez nous contacter à l'adresse {{ config('mail.from.address') }} dans le cas ou vous ne seriez par à l'origine de ce changement.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
