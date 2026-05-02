<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tâches</title>
    <link rel="stylesheet" href="/css/style_tache.css">
</head>
<body>
    @include('header')

    <div class="listes-wrapper">

        <!-- Bloc Tâches du jour (permanent, non supprimable) -->
        <div class="taches-container taches-du-jour">
            <div class="liste-header">
                <p class="taches-titre">Tâches du jour</p>
            </div>

            <!-- Ligne ajouter une tâche du jour -->
            <div class="tache-item">
                <button class="btn-ajouter" id="btn-ajouter-jour" onclick="ouvrirAjoutJour()">+</button>
                <div class="tache-zone-texte">
                    <span class="tache-label" id="label-ajouter-jour">Ajouter une tâche</span>
                    <input type="text" class="input-nouvelle-tache" id="input-nouvelle-tache-jour"
                           placeholder="Nom de la tâche..."
                           onkeydown="if(event.key==='Enter') confirmerAjoutJour()"
                           style="display:none;">
                </div>
                <button class="btn-confirmer" id="btn-confirmer-jour" onclick="confirmerAjoutJour()" style="display:none;">✓</button>
            </div>

            <div id="liste-du-jour">
                @forelse($tachesduJour as $tache)
                <div class="tache-item" data-id="{{ $tache->id }}">
                    <input type="checkbox"
                           id="tache-jour-{{ $tache->id }}"
                           {{ $tache->completee ? 'checked' : '' }}
                           onchange="toggleTache({{ $tache->id }}, this)">
                    <label class="tache-label" for="tache-jour-{{ $tache->id }}">{{ $tache->description }}</label>
                    <button class="btn-supprimer" onclick="supprimerTache({{ $tache->id }}, this)">×</button>
                </div>
                @empty
                <p class="taches-vides">Aucune tâche pour aujourd'hui.</p>
                @endforelse
            </div>
        </div>

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
                    div.className = 'tache-item tache-nouveau';
                    div.dataset.id = tache.id;
                    div.innerHTML =
                        '<input type="checkbox" id="tache-' + tache.id + '" onchange="toggleTache(' + tache.id + ', this)">' +
                        '<label class="tache-label" for="tache-' + tache.id + '">' + escapeHtml(tache.description) + '</label>' +
                        '<button class="btn-supprimer" onclick="supprimerTache(' + tache.id + ', this)">×</button>';
                    conteneur.prepend(div);
                    requestAnimationFrame(() => div.classList.remove('tache-nouveau'));
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

        function ouvrirAjoutJour() {
            document.getElementById('label-ajouter-jour').style.display = 'none';
            document.getElementById('input-nouvelle-tache-jour').style.display = 'block';
            document.getElementById('btn-confirmer-jour').style.display = 'flex';
            document.getElementById('btn-ajouter-jour').style.display = 'none';
            document.getElementById('input-nouvelle-tache-jour').focus();
        }

        async function confirmerAjoutJour() {
            const input = document.getElementById('input-nouvelle-tache-jour');
            const texte = input.value.trim();

            if (texte !== '') {
                const res = await fetch('/taches', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ description: texte, liste_id: null }),
                });

                if (res.ok) {
                    const tache = await res.json();
                    const conteneur = document.getElementById('liste-du-jour');
                    const vide = conteneur.querySelector('.taches-vides');
                    if (vide) vide.remove();
                    const div = document.createElement('div');
                    div.className = 'tache-item tache-nouveau';
                    div.dataset.id = tache.id;
                    div.innerHTML =
                        '<input type="checkbox" id="tache-jour-' + tache.id + '" onchange="toggleTache(' + tache.id + ', this)">' +
                        '<label class="tache-label" for="tache-jour-' + tache.id + '">' + escapeHtml(tache.description) + '</label>' +
                        '<button class="btn-supprimer" onclick="supprimerTache(' + tache.id + ', this)">×</button>';
                    conteneur.prepend(div);
                    requestAnimationFrame(() => div.classList.remove('tache-nouveau'));
                }
            }

            input.value = '';
            input.style.display = 'none';
            document.getElementById('btn-confirmer-jour').style.display = 'none';
            document.getElementById('btn-ajouter-jour').style.display = 'flex';
            document.getElementById('label-ajouter-jour').style.display = 'block';
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
