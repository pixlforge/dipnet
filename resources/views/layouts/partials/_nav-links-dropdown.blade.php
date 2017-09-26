<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
   aria-haspopup="true"
   aria-expanded="false">
    @auth
        {{ Auth::user()->username }}
    @endauth
</a>
<div class="dropdown-menu">
    @auth
        <a href="{{ route('profile') }}" class="dropdown-item">
            Profil
        </a>
        <a href="{{ route('logout') }}" class="dropdown-item">
            Déconnexion
        </a>

        @admin
            <hr>
            <a href="{{ route('companies.index') }}" class="dropdown-item">Sociétés</a>
            <a href="{{ route('businesses.index') }}" class="dropdown-item">Affaires</a>
            <a href="{{ route('orders.index') }}" class="dropdown-item">Commandes</a>
            <a href="{{ route('contacts.index') }}" class="dropdown-item">Contacts</a>
            <a href="{{ route('deliveries.index') }}" class="dropdown-item">Livraisons</a>
            <a href="{{ route('documents.index') }}" class="dropdown-item">Documents</a>
            <hr>
            <a href="{{ route('formats.index') }}" class="dropdown-item">Formats</a>
            <a href="{{ route('categories.index') }}" class="dropdown-item">Catégories</a>
            <a href="{{ route('articles.index') }}" class="dropdown-item">Articles</a>
            <a href="{{ route('users.index') }}" class="dropdown-item">Utilisateurs</a>
        @endadmin
    @endauth
</div>