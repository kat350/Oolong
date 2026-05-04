<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendrier</title>
    <style>

        :root {
            --bg-brown:    #a07850;
            --bg-cream:    #f5e6c8;
            --card-bg:     #fdf3dc;
            --text-dark:   #2c1a0e;
            --accent:      #6b4c2a;
            --today-bg:    #2c1a0e;
            --today-text:  #f5e6c8;
            --reunion-color: #7b5ea7;
            --tache-color:   #4a7c59;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        .contenu-principal {
            padding: 30px 40px;
        }

        body {
            background: var(--bg-brown);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            padding: 0px;
        }

        footer {
            background-color: rgba(255, 245, 227, 1) !important;
        }

        h1 {
            color: var(--text-dark);
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* ===== NAVIGATION MOIS ===== */
        .nav-mois {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--card-bg);
            border-radius: 12px;
            padding: 10px 16px;
            display: inline-flex;
            margin-bottom: 16px;
        }

        .nav-mois a {
            text-decoration: none;
            color: var(--accent);
            font-size: 1.2rem;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .nav-mois a:hover { background: var(--bg-cream); }

        .nav-mois span {
            font-weight: 600;
            color: var(--text-dark);
            min-width: 160px;
            text-align: center;
        }

        /* ===== GRILLE DU CALENDRIER ===== */
        .calendrier-container {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 20px;
        }

        .jours-semaine {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 8px;
        }

        .jours-semaine div {
            text-align: center;
            font-weight: 600;
            color: var(--accent);
            font-size: 0.85rem;
            padding: 8px 0;
        }

        .grille {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .jour {
            background: var(--bg-cream);
            border-radius: 8px;
            padding: 6px;
            min-height: 80px;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }
        .jour:hover { background: #eedcb4; }

        .jour.vide { background: transparent; cursor: default; }

        .jour.aujourd-hui .num-jour {
            background: var(--today-bg);
            color: var(--today-text);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .num-jour {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 4px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== ÉVÉNEMENTS ===== */
        .event {
            font-size: 0.7rem;
            border-radius: 4px;
            padding: 2px 5px;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }
        .event.reunion {
            background: var(--reunion-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
        }
        .event.tache {
            background: var(--tache-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
        }

        .btn-suppr-event {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
        }

        .btn-suppr-event:hover {
            color: #fff;
        }

        /* ===== BOUTON AJOUTER ===== */
        .btn-ajouter {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-bottom: 16px;
            transition: background 0.2s;
        }
        .btn-ajouter:hover { background: var(--today-bg); }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.actif { display: flex; }

        .modal {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            width: 400px;
            max-width: 95vw;
        }
        .modal h2 { color: var(--text-dark); margin-bottom: 16px; }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }
        .tab {
            padding: 6px 16px;
            border-radius: 6px;
            border: 2px solid var(--accent);
            background: transparent;
            color: var(--accent);
            cursor: pointer;
            font-weight: 600;
        }
        .tab.actif {
            background: var(--accent);
            color: white;
        }

        .form-group { margin-bottom: 12px; }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--accent);
            margin-bottom: 4px;
            font-weight: 600;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #c9a96e;
            border-radius: 6px;
            background: var(--bg-cream);
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }
        .btn-cancel {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-submit {
            background: var(--accent);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* ===== MESSAGE DE SUCCÈS ===== */
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
@include('header')
<div class="contenu-principal">

    <h1>Calendriers de {{ auth()->user()->name }}</h1>
    
    {{-- Message de succès après ajout --}}
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    
    {{-- Navigation entre les mois --}}
    @php
        // On calcule le mois précédent et suivant
        $moisPrecedent = \Carbon\Carbon::create($annee, $mois, 1)->subMonth();
        $moisSuivant   = \Carbon\Carbon::create($annee, $mois, 1)->addMonth();
        $nomsMois = ['', 'Janvier','Février','Mars','Avril','Mai','Juin',
                     'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    @endphp
    
    <div class="nav-mois">
        <a href="{{ route('calendrier', ['mois' => $moisPrecedent->month, 'annee' => $moisPrecedent->year]) }}">‹</a>
        <span>{{ $nomsMois[$mois] }} {{ $annee }}</span>
        <a href="{{ route('calendrier', ['mois' => $moisSuivant->month, 'annee' => $moisSuivant->year]) }}">›</a>
    </div>
    
    <button class="btn-ajouter" onclick="ouvrirModal()">+ Ajouter</button>
    
    {{-- Grille du calendrier --}}
    <div class="calendrier-container">
        <div class="jours-semaine">
            <div>Dim</div><div>Lun</div><div>Mar</div>
            <div>Mer</div><div>Jeu</div><div>Ven</div><div>Sam</div>
        </div>
    
        <div class="grille">
            @php
                $premierJour = $debutMois->dayOfWeek; // 0=Dim, 1=Lun...
                $nbJours     = $debutMois->daysInMonth;
                $today       = now()->format('Y-m-d');
            @endphp
    
            {{-- Cases vides avant le 1er du mois --}}
            @for($i = 0; $i < $premierJour; $i++)
                <div class="jour vide"></div>
            @endfor
    
            {{-- Les jours du mois --}}
            @for($jour = 1; $jour <= $nbJours; $jour++)
                @php
                    $dateStr = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
                    $estAujourdhui = ($dateStr === $today);
                @endphp
    
                <div class="jour {{ $estAujourdhui ? 'aujourd-hui' : '' }}"
                     onclick="ouvrirModal('{{ $dateStr }}')">
    
                    <div class="num-jour">{{ $jour }}</div>
    
                    {{-- Réunions du jour --}}
                    @if(isset($reunions[$dateStr]))
                        @foreach($reunions[$dateStr] as $r)
                            <div class="event reunion" title="{{ $r->titre }}" id="reunion-cal-{{ $r->id }}">
                                <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">📅 {{ $r->titre }}</span>
                                <button class="btn-suppr-event" onclick="event.stopPropagation(); supprimerReunionCal({{ $r->id }})" title="Supprimer">×</button>
                            </div>
                        @endforeach
                    @endif
    
                    {{-- Tâches du jour --}}
                    @if(isset($taches[$dateStr]))
                        @foreach($taches[$dateStr] as $t)
                            <div class="event tache" title="{{ $t->titre }}" id="tache-cal-{{ $t->id }}">
                                ✅ {{ $t->titre }}
                                <button class="btn-suppr-event" onclick="event.stopPropagation(); supprimerTacheCal({{ $t->id }})" title="Supprimer">×</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
    </div>
    
    {{-- MODAL D'AJOUT --}}
    <div class="modal-overlay" id="modal">
        <div class="modal">
            <h2>Ajouter un événement</h2>
    
            <div class="tabs">
                <button class="tab actif" id="tab-reunion" onclick="switchTab('reunion')">📅 Réunion</button>
                <button class="tab" id="tab-tache"   onclick="switchTab('tache')">✅ Tâche</button>
            </div>
    
            {{-- Formulaire Réunion --}}
            <form id="form-reunion" action="{{ route('calendrier.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Titre *</label>
                    <input type="text" name="titre" required placeholder="Nom de la réunion">
                </div>
                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" name="date_reunion" id="date-reunion" required>
                </div>
                <div class="form-group">
                    <label>Heure début</label>
                    <input type="time" name="heure_debut">
                </div>
                <div class="form-group">
                    <label>Heure fin</label>
                    <input type="time" name="heure_fin">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Optionnel..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="fermerModal()">Annuler</button>
                    <button type="submit" class="btn-submit">Enregistrer</button>
                </div>
            </form>
    
            {{-- Formulaire Tâche --}}
            <form id="form-tache" action="{{ route('taches.store') }}" method="POST" style="display:none">
                @csrf
                <div class="form-group">
                    <label>Titre *</label>
                    <input type="text" name="titre" required placeholder="Nom de la tâche">
                </div>
                <div class="form-group">
                    <label>Date d'échéance *</label>
                    <input type="date" name="date_echeance" id="date-tache" required>
                </div>
                <div class="form-group">
                    <label>Statut</label>
                    <select name="statut">
                        <option value="todo">À faire</option>
                        <option value="en_cours">En cours</option>
                        <option value="terminee">Terminée</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Optionnel..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="fermerModal()">Annuler</button>
                    <button type="submit" class="btn-submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // ===== GESTION DU MODAL =====
    
        function ouvrirModal(date = null) {
            document.getElementById('modal').classList.add('actif');
            // Si on clique sur un jour, on pré-remplit la date
            if (date) {
                document.getElementById('date-reunion').value = date;
                document.getElementById('date-tache').value   = date;
            }
        }
    
        function fermerModal() {
            document.getElementById('modal').classList.remove('actif');
        }
    
        // Fermer si on clique en dehors du modal
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) fermerModal();
        });
    
        // ===== ONGLETS RÉUNION / TÂCHE =====
    
        async function supprimerTacheCal(id) {
            const res = await fetch('/taches/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        ? document.querySelector('meta[name="csrf-token"]').content
                        : '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });
            if (res.ok) {
                document.getElementById('tache-cal-' + id).remove();
            }
        }

        async function supprimerReunionCal(id) {
            const res = await fetch('/reunion/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            if (res.ok) {
                document.getElementById('reunion-cal-' + id).remove();
            }
        }

        function switchTab(type) {
            const formReunion = document.getElementById('form-reunion');
            const formTache   = document.getElementById('form-tache');
            const tabReunion  = document.getElementById('tab-reunion');
            const tabTache    = document.getElementById('tab-tache');
    
            if (type === 'reunion') {
                formReunion.style.display = 'block';
                formTache.style.display   = 'none';
                tabReunion.classList.add('actif');
                tabTache.classList.remove('actif');
            } else {
                formTache.style.display   = 'block';
                formReunion.style.display = 'none';
                tabTache.classList.add('actif');
                tabReunion.classList.remove('actif');
            }
        }
    </script>
</div>

@include('footer')
</body>
</html>