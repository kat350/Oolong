<link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Itim&family=Lobster&display=swap" rel="stylesheet">

<header>
    @auth
    <nav class="nav">
        <ul><a href="/calendrier">Calendrier</a></ul>
        <ul><a href="/taches">Tâches</a></ul>
        <ul><a href="/reunion">Réunions</a></ul>
    </nav>
    @else
    <nav class="nav"></nav>
    @endauth

    <a href="{{ auth()->check() ? '/welcome' : '/connexion' }}">
        <img class="logo" src="../img/logo_oolong.png" alt="Logo">
    </a>

    <div class="div-bouton-recherche">
        @auth
            <form action="/recherche" method="get">
                <input class="search-box" type="text" placeholder="Rechercher...">
                <button class="search-button">🔍</button>
            </form>
            <div class="utilisateur-connecte">
                <span class="nom-utilisateur">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="bouton-connexion">Déconnexion</button>
                </form>
            </div>
        @else
            <a href="{{ route('connexion') }}">
                <button class="bouton-connexion">Connexion</button>
            </a>
            <a href="{{ route('inscription') }}">
                <button class="bouton-connexion">Inscription</button>
            </a>
        @endauth
    </div>
</header>