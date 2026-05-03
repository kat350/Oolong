<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunions</title>
    <style>
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }
        .modal-backdrop.open {
            display: flex;
        }
        .modal {
            background: #fff;
            border-radius: 12px;
            max-width: 520px;
            width: 90%;
            padding: 24px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.16);
        }
        .modal h2 {
            margin-top: 0;
        }
        .modal label {
            display: block;
            margin: 12px 0 4px;
            font-weight: 600;
        }
        .modal input,
        .modal textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccd0d5;
            border-radius: 8px;
            font-size: 1rem;
        }
        .modal textarea {
            min-height: 100px;
            resize: vertical;
        }
        .modal-actions {
            margin-top: 18px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn-ajouter,
        .btn-close,
        .btn-submit {
            cursor: pointer;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 1rem;
        }
        .btn-ajouter,
        .btn-submit {
            background: #1d4ed8;
            color: #fff;
        }
        .btn-close {
            background: #f3f4f6;
            color: #111827;
        }
        .cartes-reunion {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            margin: 16px 0;
            background: #ffffff;
        }
    </style>
</head>
<body>

    @include('header')
    <section>
        <h1>Réunions</h1>
        <button class="btn-ajouter" type="button" onclick="ouvrirModal()">Ajouter une réunion</button>

        @if(session('success'))
            <p style="color: #065f46; margin-top: 1rem;">{{ session('success') }}</p>
        @endif

        @if(count($reunions) === 0)
            <p>Il n'y a aucune réunion de prévue.</p>
        @else
            @foreach ($reunions as $reunion)
                <article class="cartes-reunion">
                    <h2>{{ $reunion->titre }}</h2>
                    <h3>{{ \Carbon\Carbon::parse($reunion->date_reunion)->format('d/m/Y') }}</h3>
                    <p>
                        @if($reunion->heure_debut)
                            {{ date('H:i', strtotime($reunion->heure_debut)) }}
                        @endif
                        @if($reunion->heure_fin)
                            - {{ date('H:i', strtotime($reunion->heure_fin)) }}
                        @endif
                    </p>
                    <p>{{ $reunion->description }}</p>
                </article>
            @endforeach
        @endif
    </section>

    <div id="reunionModal" class="modal-backdrop" onclick="fermerModal(event)">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" onclick="event.stopPropagation()">
            <h2 id="modalTitle">Ajouter une réunion</h2>
            <form method="POST" action="{{ route('reunions.store') }}">
                @csrf

                <label for="titre">Sujet</label>
                <input id="titre" name="titre" type="text" required>

                <label for="date_reunion">Date</label>
                <input id="date_reunion" name="date_reunion" type="date" required>

                <label for="heure_debut">Heure de début</label>
                <input id="heure_debut" name="heure_debut" type="time">

                <label for="heure_fin">Heure de fin</label>
                <input id="heure_fin" name="heure_fin" type="time">

                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>

                <div class="modal-actions">
                    <button type="button" class="btn-close" onclick="fermerModal()">Annuler</button>
                    <button type="submit" class="btn-submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function ouvrirModal() {
            document.getElementById('reunionModal').classList.add('open');
        }

        function fermerModal(event) {
            if (!event || event.target.id === 'reunionModal') {
                document.getElementById('reunionModal').classList.remove('open');
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('reunionModal').classList.remove('open');
            }
        });
    </script>
</body>
</html>
