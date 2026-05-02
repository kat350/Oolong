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
            margin: 0;
        }

        .listes-wrapper {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 24px;
            padding: 40px;
            align-items: flex-start;
        }

        .taches-container {
            background-color: rgba(169, 127, 100, 1);
            border-radius: 18px;
            padding: 30px 35px 40px 35px;
            width: 340px;
            min-width: 340px;
            flex-shrink: 0;
        }

        .liste-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            gap: 8px;
        }

        .taches-titre {
            color: #F5DEB3;
            font-size: 1.8rem;
            margin: 0;
            word-break: break-word;
            overflow-wrap: break-word;
            min-width: 0;
        }

        .btn-supprimer-liste {
            background: none;
            border: none;
            color: rgba(245, 222, 179, 0.5);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.2s;
            font-family: 'Indie Flower', cursive;
        }

        .btn-supprimer-liste:hover {
            color: #F5DEB3;
        }

        .tache-item {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 22px;
        }

        .tache-item input[type="checkbox"],
        .tache-item .btn-ajouter,
        .tache-item .btn-confirmer,
        .tache-item .btn-supprimer {
            margin-top: 4px;
            flex-shrink: 0;
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
            word-break: break-word;
            overflow-wrap: break-word;
            min-width: 0;
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

        .carte-nouvelle-liste {
            background-color: #F2E4CB;
            border: none;
            border-radius: 18px;
            width: 340px;
            min-width: 340px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            min-height: 200px;
            transition: background-color 0.2s;
        }

        .carte-nouvelle-liste:hover {
            background-color: rgba(240, 228, 210, 1);
        }

        .carte-nouvelle-liste-icone {
            width: 60px;
            height: 60px;
            border: 2px solid rgba(180, 160, 140, 0.6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(180, 160, 140, 0.8);
            font-size: 2rem;
            font-weight: 300;
        }

        .form-nouvelle-liste {
            background-color: rgba(169, 127, 100, 1);
            border-radius: 18px;
            padding: 30px 35px;
            width: 340px;
            min-width: 340px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .input-nom-liste {
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #F5DEB3;
            color: #F5DEB3;
            font-family: 'Indie Flower', cursive;
            font-size: 1.8rem;
            outline: none;
            text-align: center;
            box-sizing: border-box;
        }

        .input-nom-liste::placeholder {
            color: rgba(245, 222, 179, 0.5);
        }

        .form-nouvelle-liste-boutons {
            display: flex;
            gap: 12px;
        }
    </style>
</head>
<body>
    @include('header')

    <div class="listes-wrapper">

        @foreach($listes as $liste)
        <div class="taches-container" data-liste-id="{{ $liste->id }}">
            <div class="liste-header">
                <p class="taches-titre">{{ $liste->nom }}</p>
                <button class="btn-supprimer-liste" onclick="supprimerListe({{ $liste->id }}, this)">×</button>
            </div>

            <!-- Ligne ajouter une tâche -->
            <div class="tache-item">
                <button class="btn-ajouter" id="btn-ajouter-{{ $liste->id }}" onclick="ouvrirAjout({{ $liste->id }})">+</button>
                <div class="tache-zone-texte">
                    <span class="tache-label" id="label-ajouter-{{ $liste->id }}">Ajouter une tâche</span>
                    <input type="text" class="input-nouvelle-tache" id="input-nouvelle-tache-{{ $liste->id }}"
                           placeholder="Nom de la tâche..."
                           onkeydown="if(event.key==='Enter') confirmerAjout({{ $liste->id }})"
                           style="display:none;">
                </div>
                <button class="btn-confirmer" id="btn-confirmer-{{ $liste->id }}" onclick="confirmerAjout({{ $liste->id }})" style="display:none;">✓</button>
            </div>

            <!-- Liste des tâches -->
            <div id="liste-{{ $liste->id }}">
                @foreach($liste->taches as $tache)
                <div class="tache-item" data-id="{{ $tache->id }}">
                    <input type="checkbox"
                           id="tache-{{ $tache->id }}"
                           {{ $tache->completee ? 'checked' : '' }}
                           onchange="toggleTache({{ $tache->id }}, this)">
                    <label class="tache-label" for="tache-{{ $tache->id }}">{{ $tache->description }}</label>
                    <button class="btn-supprimer" onclick="supprimerTache({{ $tache->id }}, this)">×</button>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Carte ajouter une nouvelle liste -->
        <div class="carte-nouvelle-liste" id="carte-nouvelle-liste" onclick="ouvrirNouveleListe()">
            <div class="carte-nouvelle-liste-icone">+</div>
        </div>

        <!-- Formulaire création nouvelle liste (caché par défaut) -->
        <div class="form-nouvelle-liste" id="form-nouvelle-liste" style="display:none;">
            <input type="text" class="input-nom-liste" id="input-nouvelle-liste"
                   placeholder="Nom de la liste..."
                   onkeydown="if(event.key==='Enter') confirmerNouveleListe()">
            <div class="form-nouvelle-liste-boutons">
                <button class="btn-confirmer" onclick="confirmerNouveleListe()">✓</button>
                <button class="btn-ajouter" onclick="annulerNouveleListe()">×</button>
            </div>
        </div>

    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function ouvrirAjout(listeId) {
            document.getElementById('label-ajouter-' + listeId).style.display = 'none';
            document.getElementById('input-nouvelle-tache-' + listeId).style.display = 'block';
            document.getElementById('btn-confirmer-' + listeId).style.display = 'flex';
            document.getElementById('btn-ajouter-' + listeId).style.display = 'none';
            document.getElementById('input-nouvelle-tache-' + listeId).focus();
        }

        async function confirmerAjout(listeId) {
            const input = document.getElementById('input-nouvelle-tache-' + listeId);
            const texte = input.value.trim();

            if (texte !== '') {
                const res = await fetch('/taches', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ description: texte, liste_id: listeId }),
                });

                if (res.ok) {
                    const tache = await res.json();
                    const conteneur = document.getElementById('liste-' + listeId);
                    const div = document.createElement('div');
                    div.className = 'tache-item';
                    div.dataset.id = tache.id;
                    div.innerHTML =
                        '<input type="checkbox" id="tache-' + tache.id + '" onchange="toggleTache(' + tache.id + ', this)">' +
                        '<label class="tache-label" for="tache-' + tache.id + '">' + escapeHtml(tache.description) + '</label>' +
                        '<button class="btn-supprimer" onclick="supprimerTache(' + tache.id + ', this)">×</button>';
                    conteneur.prepend(div);
                }
            }

            input.value = '';
            input.style.display = 'none';
            document.getElementById('btn-confirmer-' + listeId).style.display = 'none';
            document.getElementById('btn-ajouter-' + listeId).style.display = 'flex';
            document.getElementById('label-ajouter-' + listeId).style.display = 'block';
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

        async function supprimerListe(listeId, btn) {
            if (!confirm('Supprimer cette liste et toutes ses tâches ?')) return;

            const res = await fetch('/listes/' + listeId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });

            if (res.ok) {
                btn.closest('.taches-container').remove();
            }
        }

        function ouvrirNouveleListe() {
            document.getElementById('carte-nouvelle-liste').style.display = 'none';
            document.getElementById('form-nouvelle-liste').style.display = 'flex';
            document.getElementById('input-nouvelle-liste').focus();
        }

        function annulerNouveleListe() {
            document.getElementById('form-nouvelle-liste').style.display = 'none';
            document.getElementById('carte-nouvelle-liste').style.display = 'flex';
            document.getElementById('input-nouvelle-liste').value = '';
        }

        async function confirmerNouveleListe() {
            const input = document.getElementById('input-nouvelle-liste');
            const nom = input.value.trim();
            if (nom === '') return;

            const res = await fetch('/listes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ nom }),
            });

            if (res.ok) {
                const liste = await res.json();
                const wrapper = document.querySelector('.listes-wrapper');
                const carteElem = document.getElementById('carte-nouvelle-liste');
                const formElem = document.getElementById('form-nouvelle-liste');

                const div = document.createElement('div');
                div.className = 'taches-container';
                div.dataset.listeId = liste.id;
                div.innerHTML = `
                    <div class="liste-header">
                        <p class="taches-titre">${escapeHtml(liste.nom)}</p>
                        <button class="btn-supprimer-liste" onclick="supprimerListe(${liste.id}, this)">×</button>
                    </div>
                    <div class="tache-item">
                        <button class="btn-ajouter" id="btn-ajouter-${liste.id}" onclick="ouvrirAjout(${liste.id})">+</button>
                        <div class="tache-zone-texte">
                            <span class="tache-label" id="label-ajouter-${liste.id}">Ajouter une tâche</span>
                            <input type="text" class="input-nouvelle-tache" id="input-nouvelle-tache-${liste.id}"
                                   placeholder="Nom de la tâche..."
                                   onkeydown="if(event.key==='Enter') confirmerAjout(${liste.id})"
                                   style="display:none;">
                        </div>
                        <button class="btn-confirmer" id="btn-confirmer-${liste.id}" onclick="confirmerAjout(${liste.id})" style="display:none;">✓</button>
                    </div>
                    <div id="liste-${liste.id}"></div>
                `;

                wrapper.insertBefore(div, carteElem);

                input.value = '';
                formElem.style.display = 'none';
                carteElem.style.display = 'flex';
            }
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
