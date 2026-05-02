<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oolong</title>
    <style>
        body {
            background-color: rgba(255, 245, 227, 1);
            font-family: 'Indie Flower', cursive;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .welcome-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px 40px;
        }

        .welcome-titre {
            font-family: 'Indie Flower', cursive;
            font-size: 3rem;
            color: rgba(108, 60, 16, 1);
            text-align: center;
            margin: 0 0 50px 0;
            line-height: 1.3;
            max-width: 800px;
        }

        .welcome-card {
            background-color: #8a6640;
            border-radius: 24px;
            padding: 32px 40px 36px;
            width: 100%;
            max-width: 580px;
        }

        .welcome-card-titre {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Indie Flower', cursive;
            font-size: 1.6rem;
            color: #F5DEB3;
            margin-bottom: 16px;
        }

        .welcome-feuille {
            width: 28px;
            height: auto;
        }

        .welcome-taches-liste {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .welcome-tache-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(245, 222, 179, 0.25);
            font-family: 'Indie Flower', cursive;
            font-size: 1.3rem;
            color: #FFFFFF;
        }

        .welcome-tache-item input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            min-width: 24px;
            background-color: #E8DECE;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
        }

        .welcome-tache-item input[type="checkbox"]:checked {
            background-color: #D4B896;
        }

        .welcome-tache-item input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #7A5230;
            font-size: 1rem;
            font-weight: bold;
        }

        .welcome-tache-label {
            cursor: pointer;
            flex: 1;
        }

        .welcome-tache-label.completee {
            text-decoration: line-through;
            opacity: 0.6;
        }

        .welcome-tache-item input[type="checkbox"]:checked + .welcome-tache-label {
            text-decoration: line-through;
            opacity: 0.6;
        }

        .welcome-check {
            color: #7abf52;
            font-size: 1.2rem;
            font-weight: bold;
            flex-shrink: 0;
            margin-left: 12px;
        }

        .welcome-tache-vide {
            font-family: 'Indie Flower', cursive;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.5);
            padding: 12px 0;
            text-align: center;
        }

        .welcome-btn-voir-plus {
            display: block;
            margin: 24px auto 0;
            width: fit-content;
            padding: 10px 40px;
            background-color: #F2E4CB;
            color: #7A5230;
            border-radius: 50px;
            font-family: 'Indie Flower', cursive;
            font-size: 1.3rem;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s;
        }

        .welcome-btn-voir-plus:hover {
            background-color: #e8cb8a;
        }
    </style>
</head>
<body>
    @include('header')

    <main class="welcome-main">

        <h1 class="welcome-titre">Bienvenue sur votre espace, @auth{{ auth()->user()->name }}@else par ici !@endauth</h1>

        <div class="welcome-card">
            <div class="welcome-card-titre">
                <img src="{{ asset('img/feuille_logo_mini.png') }}" alt="" class="welcome-feuille">
                <span>Tâches du jour :</span>
            </div>

            <ul class="welcome-taches-liste">
                @forelse($tachesduJour as $tache)
                <li class="welcome-tache-item">
                    <input type="checkbox"
                           id="welcome-tache-{{ $tache->id }}"
                           {{ $tache->completee ? 'checked' : '' }}
                           onchange="toggleTache({{ $tache->id }}, this)">
                    <label class="welcome-tache-label {{ $tache->completee ? 'completee' : '' }}" for="welcome-tache-{{ $tache->id }}">{{ $tache->description }}</label>
                </li>
                @empty
                <li class="welcome-tache-vide">Aucune tâche pour aujourd'hui.</li>
                @endforelse
            </ul>

            <a href="{{ route('taches') }}" class="welcome-btn-voir-plus">Voir plus</a>
        </div>

    </main>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function toggleTache(id, checkbox) {
            await fetch('/taches/' + id, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
            const label = checkbox.nextElementSibling;
            if (checkbox.checked) {
                label.style.textDecoration = 'line-through';
                label.style.opacity = '0.6';
            } else {
                label.style.textDecoration = 'none';
                label.style.opacity = '1';
            }
        }
    </script>

    @include('footer')
</body>
</html>
