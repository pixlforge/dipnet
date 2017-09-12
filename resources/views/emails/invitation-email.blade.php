@component('mail::message')
# Invitation à rejoindre {{ $user->company->name }} sur {{ config('app.name') }}

Vous avez été invité à créer un compte sur la plateforme {{ config('app.name') }} et rejoindre {{ $user->company->name }}.

@component('mail::button', ['url' => url('/invite/confirm?token=' . $user->confirmation_token), 'color' => 'red'])
    Rejoindre {{ $user->company->name }}
@endcomponent

Veuillez ignorer ce message dans le cas où cela ne vous concerne pas.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent