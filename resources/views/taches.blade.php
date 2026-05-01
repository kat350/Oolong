<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tâches</title>
    <style>
        body {
            background-color: rgba(255, 245, 227, 1);
            font-family: 'Indie Flower', cursive;
        }

        .taches-container {
            background-color: #B07848;
            border-radius: 18px;
            padding: 35px 45px 50px 45px;
            width: 90%;
            max-width: 1050px;
            margin: 40px auto;
        }

        .taches-titre {
            color: #F5DEB3;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        .tache-item {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 22px;
        }

        .tache-item input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 28px;
            height: 28px;
            min-width: 28px;
            background-color: #E8DECE;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s;
        }

        .tache-item input[type="checkbox"]:checked {
            background-color: #D4B896;
        }

        .tache-item input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #7A5230;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .tache-label {
            color: #FFFFFF;
            font-size: 1.5rem;
            cursor: pointer;
            flex: 1;
            transition: opacity 0.2s;
        }

        .tache-item input[type="checkbox"]:checked + .tache-label {
            text-decoration: line-through;
            opacity: 0.7;
        }

        .btn-ajouter {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background-color: #E8DECE;
            border: none;
            border-radius: 4px;
            color: #7A5230;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Indie Flower', cursive;
        }

        .tache-zone-texte {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .input-nouvelle-tache {
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #E8DECE;
            color: #FFFFFF;
            font-family: 'Indie Flower', cursive;
            font-size: 1.5rem;
            outline: none;
            padding: 2px 6px;
        }

        .input-nouvelle-tache::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-confirmer {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background-color: #E8DECE;
            border: none;
            border-radius: 4px;
            color: #7A5230;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-supprimer {
            margin-left: auto;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.6rem;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.2s;
            min-width: 24px;
            font-family: 'Indie Flower', cursive;
        }

        .btn-supprimer:hover {
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    @include('header')

    <div class="taches-container">
        <p class="taches-titre">Tâches :</p>

        <!-- Ligne ajouter -->
        <div class="tache-item" id="row-ajouter">
            <button class="btn-ajouter" id="btn-ajouter" onclick="ouvrirAjout()">+</button>
            <div class="tache-zone-texte">
                <span class="tache-label" id="label-ajouter">Ajouter une tâche</span>
                <input type="text" class="input-nouvelle-tache" id="input-nouvelle-tache"
                       placeholder="Nom de la tâche..."
                       onkeydown="if(event.key==='Enter') confirmerAjout()"
                       style="display:none;">
            </div>
            <button class="btn-confirmer" id="btn-confirmer" onclick="confirmerAjout()" style="display:none;">✓</button>
        </div>

        <!-- Liste des tâches depuis la BDD -->
        <div id="liste-taches">
            @foreach ($taches as $tache)
                <div class="tache-item" data-id="{{ $tache->id }}">
                    <input type="checkbox"
                           id="tache-{{ $tache->id }}"
                           {{ $tache->completee ? 'checked' : '' }}
                           onchange="toggleTache({{ $tache->id }}, this)">
                           <label class="tache-label" for="tache-{{ $tache->id }}">{{ $tache->titre }}</label>
                    <button class="btn-supprimer" onclick="supprimerTache({{ $tache->id }}, this)">×</button>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function ouvrirAjout() {
            document.getElementById('label-ajouter').style.display = 'none';
            document.getElementById('input-nouvelle-tache').style.display = 'block';
            document.getElementById('btn-confirmer').style.display = 'flex';
            document.getElementById('btn-ajouter').style.display = 'none';
            document.getElementById('input-nouvelle-tache').focus();
        }

        async function confirmerAjout() {
            const input = document.getElementById('input-nouvelle-tache');
            const texte = input.value.trim();

            if (texte !== '') {
                const res = await fetch('/taches', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ description: texte }),
                });

                if (res.ok) {
                    const tache = await res.json();
                    const liste = document.getElementById('liste-taches');
                    const div = document.createElement('div');
                    div.className = 'tache-item';
                    div.dataset.id = tache.id;
                    div.innerHTML =
                        '<input type="checkbox" id="tache-' + tache.id + '" onchange="toggleTache(' + tache.id + ', this)">' +
                        '<label class="tache-label" for="tache-' + tache.id + '">' + escapeHtml(tache.titre) + '</label>' +
                        '<button class="btn-supprimer" onclick="supprimerTache(' + tache.id + ', this)">×</button>';
                    liste.prepend(div);
                }
            }

            input.value = '';
            input.style.display = 'none';
            document.getElementById('btn-confirmer').style.display = 'none';
            document.getElementById('btn-ajouter').style.display = 'flex';
            document.getElementById('label-ajouter').style.display = 'block';
        }

        async function toggleTache(id, checkbox) {
            await fetch('/taches/' + id, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
        }

        async function supprimerTache(id, btn) {
            await fetch('/taches/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
            btn.closest('.tache-item').remove();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }
    </script>

    @include('footer')
</body>
</html>