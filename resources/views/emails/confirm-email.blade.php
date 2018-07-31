@component('mail::message')
# Confirmation de création de votre compte

Aidez-nous à déterminer que vous êtes bien un humain en confirmant la création de votre compte Dipnet à l'aide du bouton ci-dessous :)

@component('mail::button', ['url' => url(route('register.confirm.index', ['token' => $user->confirmation_token])), 'color' => 'red'])
    Confirmer la création de mon compte
@endcomponent

Veuillez ignorer ce message si vous n'êtes pas à l'origine de son envoi et que cela ne vous concerne pas.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent