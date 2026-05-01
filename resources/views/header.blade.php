<link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Itim&family=Lobster&display=swap" rel="stylesheet">

<header>
    <nav class="nav">
        <ul><a href="/calendrier">Calendrier</a></ul>
        <ul><a href="/taches">Tâches</a></ul>
        <ul><a href="/reunion">Reunions</a></ul>
    </nav>
    <a href="/welcome">
        <img class="logo" src="../img/logo_oolong.png" alt="Logo">
    </a>
    <div class="div-bouton-recherche">
        <form action="/recherche" method="get">
            <input class="search-box" type="text" placeholder="Rechercher...">
            <button class="search-button">🔍</button>
        </form>

        @auth
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
        @endauth
    </div>
</header>