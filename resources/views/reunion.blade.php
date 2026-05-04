<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunion – Oolong</title>
    <style>

        :root {
            --beige:      #f5eddc;
            --brun:       #7a5230;
            --brun-clair: #c49a6c;
            --card-bg:    #fdf3d8;
            --text-dark:  #3b2510;
            --text-mid:   #6b4226;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--beige);
            font-family: Georgia, 'Times New Roman', serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ── Section principale ── */
        main {
            padding: 0 40px 60px;
        }

        /* ── Flash messages ── */
        .flash {
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            padding: 10px 18px;
            margin-bottom: 16px;
            font-size: 0.9rem;
        }

        /* ── Bloc réunions ── */
        .reunions-block {
            background: var(--brun);
            border-radius: 20px;
            padding: 30px 36px;
            margin-bottom: 40px;
        }

        .reunions-block h2 {
            color: var(--card-bg);
            font-size: 1.2rem;
            font-weight: normal;
            margin-bottom: 24px;
            letter-spacing: 0.03em;
        }

        /* ── Grille de cartes ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* ── Carte réunion ── */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            padding: 18px 16px 14px;
            text-align: center;
            border-bottom: 1px solid #d4b896;
        }

        .card-header .sujet {
            font-size: 1.3rem;
            color: var(--text-dark);
            font-family: Georgia, serif;
        }

        .card-body {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid #d4b896;
        }

        .card-body .date {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .card-body .heure {
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .card-footer {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-footer .voir {
            color: var(--brun-clair);
            font-size: 0.95rem;
            cursor: pointer;
            background: none;
            border: none;
            font-family: inherit;
            text-decoration: underline;
        }

        .card-footer .suppr {
            color: #b05030;
            font-size: 0.8rem;
            cursor: pointer;
            background: none;
            border: none;
            font-family: inherit;
        }

        .card-footer .auteur {
            font-size: 0.75rem;
            color: #a07850;
        }

        /* ── Message vide ── */
        .empty {
            color: var(--card-bg);
            font-style: italic;
            text-align: center;
            padding: 30px 0;
        }

        /* ── Bouton ajouter ── */
        .btn-ajouter {
            background: var(--brun);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-size: 1rem;
            cursor: pointer;
            font-family: inherit;
            margin-bottom: 20px;
        }
        .btn-ajouter:hover { background: var(--brun-clair); }

        /* ── Erreurs de validation ── */
        .error { color: #c0392b; font-size: 0.8rem; }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.actif { display: flex; }

        .modal {
            background: white;
            border-radius: 16px;
            padding: 28px 32px;
            width: 420px;
            max-width: 95vw;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .modal h2 { 
            color: var(--brun);
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        .modal .form-group {
            margin-bottom: 14px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .modal .form-group label {
            font-size: 0.85rem;
            color: var(--text-mid);
            font-weight: 600;
        }
        .modal .form-group input,
        .modal .form-group select,
        .modal .form-group textarea {
            border: 1px solid #d4b896;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--text-dark);
            background: var(--beige);
            outline: none;
        }
        .modal .form-group input:focus,
        .modal .form-group select:focus,
        .modal .form-group textarea:focus {
            border-color: var(--brun-clair);
        }
        .modal .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 20px;
        }
        .btn-close {
            background: #f3f4f6;
            color: #111827;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-close:hover {
            background: #e5e7eb;
        }
        .modal .btn-submit {
            background: var(--brun);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 1rem;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            transition: background 0.2s;
        }
        .modal .btn-submit:hover { 
            background: var(--brun-clair);
        }

        /* ── Modal de détails ── */
        .details-modal {
            background: white;
            border-radius: 16px;
            padding: 28px 32px;
            width: 500px;
            max-width: 95vw;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .details-modal h2 {
            color: var(--brun);
            margin-bottom: 24px;
            font-size: 1.3rem;
            border-bottom: 2px solid var(--brun-clair);
            padding-bottom: 12px;
        }
        .details-modal .detail-row {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e8d8b8;
        }
        .details-modal .detail-row:last-of-type {
            border-bottom: none;
        }
        .details-modal .detail-label {
            font-weight: 600;
            color: var(--text-mid);
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        .details-modal .detail-value {
            color: var(--text-dark);
            font-size: 1rem;
        }
        .details-modal .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 24px;
            border-top: 1px solid #e8d8b8;
            padding-top: 16px;
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    @include('header')

    <main>

        <!-- Flash success -->
        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        <!-- Bouton Ajouter -->
        <button class="btn-ajouter" onclick="ouvrirModal()">+ Ajouter une réunion</button>

        <!-- Bloc des réunions existantes -->
        <div class="reunions-block">
            <h2>Reunion :</h2>

            @if($reunions->isEmpty())
                <p class="empty">Aucune réunion pour le moment.</p>
            @else
                <div class="cards-grid">
                    @foreach($reunions as $reunion)
                    <div class="card">
                        <div class="card-header">
                            <div class="sujet">{{ $reunion->titre }}</div>
                        </div>

                        <div class="card-body">
                            <div class="date">{{ $reunion->date_reunion->format('d/m') }}</div>
                            <div class="heure">{{ $reunion->heure_format }}</div>
                        </div>

                        <div class="card-footer">
                            <span class="auteur">{{ $reunion->user->name }}</span>

                            <button class="voir"
                                    onclick="ouvrirDetailsModal('{{ $reunion->titre }}', '{{ $reunion->date_reunion->format('d/m/Y') }}', '{{ $reunion->heure_format }}', '{{ $reunion->user->name }}', '{{ addslashes($reunion->description ?? 'Pas de description.') }}')">
                                voir
                            </button>

                            <form action="{{ route('reunions.destroy', $reunion) }}"
                                  method="POST"
                                  onsubmit="return confirm('Supprimer cette réunion ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="suppr">✕</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- MODAL D'AJOUT --}}
        <div class="modal-overlay" id="modal">
            <div class="modal">
                <h2>Nouvelle réunion</h2>

                <form action="{{ route('reunions.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="titre">Sujet *</label>
                        <input type="text" name="titre" id="titre"
                               value="{{ old('titre') }}" required maxlength="255" placeholder="Nom de la réunion">
                        @error('titre')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="date_reunion">Date *</label>
                        <input type="date" name="date_reunion" id="date_reunion"
                               value="{{ old('date_reunion') }}" required>
                        @error('date_reunion')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="heure_debut">Heure début</label>
                            <input type="time" name="heure_debut" id="heure_debut"
                                   value="{{ old('heure_debut') }}">
                            @error('heure_debut')<span class="error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="heure_fin">Heure fin</label>
                            <input type="time" name="heure_fin" id="heure_fin"
                                   value="{{ old('heure_fin') }}">
                            @error('heure_fin')<span class="error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Optionnel...">{{ old('description') }}</textarea>
                        @error('description')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-close" onclick="fermerModal()">Annuler</button>
                        <button type="submit" class="btn-submit">Créer</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL DE DÉTAILS --}}
        <div class="modal-overlay" id="detailsModal">
            <div class="details-modal">
                <h2 id="detailTitre"></h2>

                <div class="detail-row">
                    <div class="detail-label">Date</div>
                    <div class="detail-value" id="detailDate"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Heure</div>
                    <div class="detail-value" id="detailHeure"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Créateur</div>
                    <div class="detail-value" id="detailAuteur"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Description</div>
                    <div class="detail-value" id="detailDescription"></div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-close" onclick="fermerDetailsModal()">Fermer</button>
                </div>
            </div>
        </div>

    </main>

    @include('footer')

    <script>
        function ouvrirModal() {
            document.getElementById('modal').classList.add('actif');
        }

        function fermerModal() {
            document.getElementById('modal').classList.remove('actif');
        }

        // Fermer le modal en cliquant sur le fond
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                fermerModal();
            }
        });

        // Fermer le modal de détails en cliquant sur le fond
        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                fermerDetailsModal();
            }
        });

        // Fonctions pour le modal de détails
        function ouvrirDetailsModal(titre, date, heure, auteur, description) {
            document.getElementById('detailTitre').textContent = titre;
            document.getElementById('detailDate').textContent = date;
            document.getElementById('detailHeure').textContent = heure;
            document.getElementById('detailAuteur').textContent = auteur;
            document.getElementById('detailDescription').textContent = description;
            document.getElementById('detailsModal').classList.add('actif');
        }

        function fermerDetailsModal() {
            document.getElementById('detailsModal').classList.remove('actif');
        }

        // Fermer le modal avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fermerModal();
                fermerDetailsModal();
            }
        });
    </script>