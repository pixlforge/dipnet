<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
   aria-haspopup="true"
   aria-expanded="false">
    @if (Auth::check())
        {{ Auth::user()->username }}
    @else
        <span>Compte</span>
    @endif
</a>
<div class="dropdown-menu">
    @if (Auth::check())
        <a href="{{ route('profile') }}" class="dropdown-item">
            Profil
        </a>
        <a href="{{ route('logout') }}" class="dropdown-item">
            Déconnexion
        </a>
        @if (Auth::user()->role === 'administrateur')

            <hr>

            <a href="{{ route('companies') }}" class="dropdown-item">Sociétés</a>
            <a href="{{ route('businesses') }}" class="dropdown-item">Affaires</a>
            <a href="{{ route('orders') }}" class="dropdown-item">Commandes</a>
            <a href="{{ route('contacts') }}" class="dropdown-item">Contacts</a>
            <a href="{{ route('deliveries') }}" class="dropdown-item">Livraisons</a>
            <a href="{{ route('documents') }}" class="dropdown-item">Documents</a>

            <hr>

            <a href="{{ route('formats') }}" class="dropdown-item">Formats</a>
            <a href="{{ route('categories') }}" class="dropdown-item">Catégories</a>
            <a href="{{ route('articles') }}" class="dropdown-item">Articles</a>
            <a href="{{ route('users') }}" class="dropdown-item">Utilisateurs</a>

        @endif
    @endif
</div>