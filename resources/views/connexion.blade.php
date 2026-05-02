<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Hachi+Maru+Pop&family=Handlee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_connexion.css') }}">
    <title>Connexion – Oolong</title>
</head>
<body>
    @include('header')

    <div class="connexion-wrapper">
        <div class="connexion-card">
            <h1 class="connexion-titre">Connexion</h1>

            @if ($errors->any())
                <div class="erreur">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-groupe">
                    <label class="form-label" for="email">
                        <img src="{{ asset('img/feuille_logo_mini.png') }}" class="feuille" alt=""> Email :
                    </label>
                    <input
                        class="form-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Entrez votre email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-groupe">
                    <label class="form-label" for="password">
                        <img src="{{ asset('img/feuille_logo_mini.png') }}" class="feuille" alt=""> Mot de passe :
                    </label>
                    <input
                        class="form-input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Entrez votre mot de passe"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <a href="#" class="lien-oublie">Mot de passe oublié ?</a>

                <button type="submit" class="btn-submit">Se connecter</button>
            </form>

            <a href="{{ route('inscription') }}" class="lien-inscription">
                Pas encore de compte ? S'inscrire
            </a>
        </div>
    </div>

    @include('footer')
</body>
</html>