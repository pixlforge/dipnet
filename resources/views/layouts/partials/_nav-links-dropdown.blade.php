<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
   aria-haspopup="true"
   aria-expanded="false">
    @auth
        {{ Auth::user()->username }}
    @endauth
</a>
<div class="dropdown-menu">
    @auth
        <a href="{{ route('profile.index') }}" class="dropdown-item">
            Profil
        </a>
        <a href="{{ route('logout') }}" class="dropdown-item">
            Déconnexion
        </a>

        @admin
            <hr>
            <a href="{{ route('companies.index') }}" class="dropdown-item">Sociétés</a>
            <a href="{{ route('deliveries.index') }}" class="dropdown-item">Livraisons</a>
            <a href="{{ route('documents.index') }}" class="dropdown-item">Documents</a>
            <hr>
            <a href="{{ route('formats.index') }}" class="dropdown-item">Formats</a>
            <a href="{{ route('articles.index') }}" class="dropdown-item">Articles</a>
            <a href="{{ route('users.index') }}" class="dropdown-item">Utilisateurs</a>
            <hr>
            @if (config('app.name') === 'Dipnet')
                <a href="http://dipnet.dip.ch/" target="_blank" rel="noopener noreferrer" class="dropdown-item">
                    Ancienne application
                    <i class="fal fa-external-link"></i>
                </a>
            @elseif (config('app.name') === 'Multicop')
                <a href="http://multiprint.multicop.ch/" target="_blank" rel="noopener noreferrer" class="dropdown-item">Ancienne application</a>
            @endif
        @endadmin
    @endauth
</div>