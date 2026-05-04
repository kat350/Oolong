<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Hachi+Maru+Pop&family=Handlee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_inscription.css') }}">
    <title>Inscription Oolong</title>
</head>
<body>
    @include('header')

    <div class="connexion-wrapper">
        <div class="connexion-card">
            <h1 class="connexion-titre">Inscription</h1>

            @if ($errors->any())
                <div class="erreur">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-groupe">
                    <label class="form-label" for="name">
                        <img src="{{ asset('img/feuille_logo_mini.png') }}" class="feuille" alt=""> Nom :
                    </label>
                    <input
                        class="form-input"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Entrez votre nom"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >
                </div>

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
                        placeholder="Au moins 6 caractères"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-groupe">
                    <label class="form-label" for="password_confirmation">
                        <img src="{{ asset('img/feuille_logo_mini.png') }}" class="feuille" alt=""> Confirmer le mot de passe :
                    </label>
                    <input
                        class="form-input"
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Répétez le mot de passe"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="btn-submit">Créer mon compte</button>
            </form>

            <a href="{{ route('connexion') }}" class="lien-inscription">
                Déjà un compte ? Se connecter
            </a>
        </div>
    </div>

    @include('footer')
</body>
</html>
