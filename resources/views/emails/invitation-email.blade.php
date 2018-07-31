@component('mail::message')
# Invitation à rejoindre {{ $invitation->company->name }} sur {{ config('app.name') }}

Vous avez été invité par {{ $invitation->created_by }} à créer un compte sur la plateforme {{ config('app.name') }} et rejoindre {{ $invitation->company->name }}.

@component('mail::button', ['url' => route('register.index', ['token' => $invitation->token]), 'color' => 'red'])
    Rejoindre {{ $invitation->company->name }}
@endcomponent

Veuillez ignorer ce message dans le cas où cela ne vous concerne pas.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent