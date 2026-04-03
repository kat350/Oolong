<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="">Calendrier</a></li>
                <li><a href="">Tâches</a></li>
                <li><a href="">Reunions</a></li>
            </ul>
        </nav>
        <a href="#" onclick="location.reload(); return false;">
            <img src="../img/logo_oolong.png" alt="Logo">
        </a>

        <button class="bouton-connexion">Connexion</button>
        <form action="/recherche" method="get">
            <input class="search-box" type="text" placeholder="Rechercher...">
            <button class="search-button">🔍</button>
        </form>
    </header>
    
</body>
</html>