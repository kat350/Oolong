<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
</head>
<body>
    <header>
        <nav class="nav">
            <ul><a href="">Calendrier</a></ul>
            <ul><a href="">Tâches</a></ul>
            <ul><a href="/reunion">Reunions</a></ul>
        </nav>
        <a href="#" onclick="location.reload(); return false;">
            <img class="logo" src="../img/logo_oolong.png" alt="Logo">
        </a>

        <button class="bouton-connexion">Connexion</button>

        <form action="/recherche" method="get">
            <input class="search-box" type="text" placeholder="Rechercher...">
            <button class="search-button">🔍</button>
        </form>
    </header>
    
</body>
</html>