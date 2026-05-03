@include('header')

<style>
    :root {
        --brown-dark:  #5C3D1E;
        --brown-mid:   #8B5E3C;
        --brown-light: #C4935A;
        --beige-warm:  #F5ECD7;
        --beige-card:  #EFE0C0;
        --beige-pale:  #FBF6EC;
        --text-dark:   #3B2409;
        --text-mid:    #6B4226;
        --shadow:      0 4px 18px rgba(92,61,30,0.10);
        --radius:      14px;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: rgba(255, 245, 227, 1);
        color: var(--text-dark);
    }

    main {
        max-width: 90%;
        margin: 0 auto;
        padding: 36px 20px 60px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .section-card {
        background: var(--beige-card);
        border-radius: var(--radius);
        padding: 20px 22px;
        box-shadow: var(--shadow);
    }

    .section-title {
        font-family: 'Caveat', cursive;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--brown-dark);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
    }

    .btn-voir {
        display: block;
        width: fit-content;
        margin: 14px auto 0;
        padding: 8px 24px;
        background: var(--beige-pale);
        border: 1.5px solid var(--brown-light);
        border-radius: 20px;
        font-family: 'Nunito', sans-serif;
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--brown-mid);
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-voir:hover { background: var(--brown-light); color: #fff; }

    /* Tâches + Bienvenue */
    .welcome-banner { display: flex; gap: 24px; align-items: stretch; }
    .taches-card { flex: 0 0 210px; }

    .task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--beige-pale);
        border-radius: 8px;
        padding: 8px 12px;
        margin-bottom: 8px;
        font-size: 0.85rem;
        color: var(--text-mid);
        border: 1px solid rgba(196,147,90,0.25);
    }

    .task-check { color: #7A9E7E; }

    .task-item input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        min-width: 18px;
        background-color: var(--beige-warm);
        border: 1.5px solid var(--brown-light);
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
    }

    .task-item input[type="checkbox"]:checked {
        background-color: #7A9E7E;
        border-color: #7A9E7E;
    }

    .task-item input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .task-item label {
        cursor: pointer;
        flex: 1;
        margin-left: 8px;
    }

    .task-item input[type="checkbox"]:checked + label {
        text-decoration: line-through;
        opacity: 0.6;
    }

    .task-empty {
        font-size: 0.82rem;
        color: var(--text-mid);
        font-style: italic;
        text-align: center;
        padding: 10px 0;
    }

    .bienvenue-text { flex: 1; display: flex; align-items: center; }

    .bienvenue-text h1 {
        font-family: 'Caveat', cursive;
        font-size: 3rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.2;
    }

    .bienvenue-text h1 .username { color: var(--brown-light); }

    /* Réunions */
    .reunions-section {
        background: var(--brown-mid);
        border-radius: var(--radius);
        padding: 22px 24px;
        box-shadow: var(--shadow);
    }

    .reunions-section .section-title { color: var(--beige-warm); }

    .reunions-grid { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 4px; }

    .reunion-card {
        flex: 1;
        min-width: 160px;
        background: var(--beige-card);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .reunion-sujet {
        font-family: 'Caveat', cursive;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--brown-dark);
    }

    .reunion-horaire { font-size: 0.82rem; font-weight: 600; color: var(--text-mid); }

    .reunion-voir { font-size: 0.78rem; color: var(--brown-light); text-decoration: none; font-weight: 600; }

    .reunion-empty { color: var(--beige-warm); font-size: 0.85rem; font-style: italic; text-align: center; padding: 10px 0; }

    .reunions-section .btn-voir { background: var(--beige-pale); border-color: var(--beige-card); color: var(--brown-mid); }

    /* Calendrier */
    .calendrier-section {
        background: var(--brown-mid);
        border-radius: var(--radius);
        padding: 22px 24px;
        box-shadow: var(--shadow);
    }

    .calendrier-section .section-title { color: var(--beige-warm); font-size: 1.8rem; }

    .week-calendar { background: var(--beige-card); border-radius: 10px; overflow: hidden; }

    .week-header { display: grid; grid-template-columns: 55px repeat(7, 1fr); background: var(--brown-dark); }

    .corner { /* vide */ }

    .day-col-header {
        padding: 10px 4px;
        text-align: center;
        color: var(--beige-warm);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .day-col-header .day-num {
        display: block;
        font-family: 'Caveat', cursive;
        font-size: 1.3rem;
        font-weight: 700;
        margin-top: 2px;
    }

    .day-col-header.today { background: var(--brown-light); }

    .week-body { display: grid; grid-template-columns: 55px repeat(7, 1fr); }

    .time-slot {
        font-size: 0.68rem;
        color: var(--text-mid);
        padding: 8px 5px 0;
        text-align: right;
        border-top: 1px solid rgba(196,147,90,0.2);
    }

    .day-cell {
        border-left: 1px solid rgba(196,147,90,0.15);
        border-top: 1px solid rgba(196,147,90,0.15);
        min-height: 36px;
        position: relative;
    }

    .day-cell.today-col { background: rgba(196,147,90,0.08); }

    .event-chip {
        position: absolute;
        inset: 2px;
        background: var(--brown-light);
        color: #fff;
        border-radius: 5px;
        font-size: 0.66rem;
        font-weight: 700;
        padding: 2px 5px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .tache-chip {
        background: #7A9E7E;
    }

    .calendrier-section .btn-voir { background: var(--beige-pale); border-color: var(--beige-card); color: var(--brown-mid); }
</style>

<main>

    {{-- Tâches + Bienvenue --}}
    <div class="welcome-banner">
        <div class="section-card taches-card">
            <div class="section-title"><img src="{{ asset('img/feuille_logo_mini.png') }}" alt="" style="width:20px;height:auto;vertical-align:middle;"> Tâches du jour :</div>

            @forelse ($taches as $tache)
                <div class="task-item">
                    <input type="checkbox"
                           id="wtache-{{ $tache->id }}"
                           {{ $tache->completee ? 'checked' : '' }}
                           onchange="toggleTache({{ $tache->id }}, this)">
                    <label for="wtache-{{ $tache->id }}">{{ $tache->titre }}</label>
                </div>
            @empty
                <p class="task-empty">Aucune tâche pour aujourd'hui</p>
            @endforelse

            <a href="{{ route('taches') }}" class="btn-voir">Voir plus</a>
        </div>

        <div class="bienvenue-text">
            <h1>
                Bienvenue sur votre<br>
                espace,<br>
                <span class="username">{{ auth()->user()->name ?? 'Utilisateur' }}</span>&nbsp;!
            </h1>
        </div>
    </div>

    {{-- Réunions du jour --}}
    <div class="reunions-section">
        <div class="section-title"><img src="{{ asset('img/feuille_logo_mini.png') }}" alt="" style="width:20px;height:auto;vertical-align:middle;"> Reunions du jour :</div>

        @if ($reunions->isEmpty())
            <p class="reunion-empty">Aucune réunion aujourd'hui</p>
        @else
            <div class="reunions-grid">
                @foreach ($reunions as $reunion)
                    <div class="reunion-card">
                        <div class="reunion-sujet">{{ $reunion->titre }}</div>
                        <div class="reunion-horaire">
                            {{ $reunion->heure_debut ? \Carbon\Carbon::parse($reunion->heure_debut)->format('H\hi') : '' }}
                            @if ($reunion->heure_fin)
                                – {{ \Carbon\Carbon::parse($reunion->heure_fin)->format('H\hi') }}
                            @endif
                        </div>
                        <a href="#" class="reunion-voir">voir</a>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('reunion') }}" class="btn-voir">Voir plus</a>
    </div>

    {{-- Calendrier de la semaine --}}
    <div class="calendrier-section">
        <div class="section-title">Calendriers</div>
        <div class="week-calendar" id="weekCalendar"></div>
        <a href="{{ route('calendrier') }}" class="btn-voir">Voir plus</a>
    </div>

</main>

<script>
(function () {
    const DAYS  = ['Di','Lu','Ma','Me','Je','Ve','Sa'];
    const HOURS = [8,9,10,11,12,13,14,15,16,17,18];

    // Données injectées depuis HomeController
    const EVENTS = @json($evenements);

    const today  = new Date();
    const monday = new Date(today);
    const dow    = today.getDay();
    monday.setDate(today.getDate() + (dow === 0 ? -6 : 1 - dow));

    const weekDays = Array.from({ length: 7 }, (_, i) => {
        const d = new Date(monday);
        d.setDate(monday.getDate() + i);
        return d;
    });

    const cal = document.getElementById('weekCalendar');

    // Header jours
    const header = document.createElement('div');
    header.className = 'week-header';
    const corner = document.createElement('div');
    corner.className = 'corner';
    header.appendChild(corner);
    weekDays.forEach(d => {
        const isToday = d.toDateString() === today.toDateString();
        const col = document.createElement('div');
        col.className = 'day-col-header' + (isToday ? ' today' : '');
        col.innerHTML = `${DAYS[d.getDay()]}<span class="day-num">${d.getDate()}</span>`;
        header.appendChild(col);
    });
    cal.appendChild(header);

    // Body heures × jours
    const body = document.createElement('div');
    body.className = 'week-body';
    HOURS.forEach(h => {
        const ts = document.createElement('div');
        ts.className = 'time-slot';
        ts.textContent = h + 'h';
        body.appendChild(ts);

        weekDays.forEach(d => {
            const isToday = d.toDateString() === today.toDateString();
            const cell = document.createElement('div');
            cell.className = 'day-cell' + (isToday ? ' today-col' : '');
            EVENTS.forEach(ev => {
                if (ev.dayOfWeek === d.getDay() && ev.hour === h) {
                    const chip = document.createElement('div');
                    chip.className = 'event-chip' + (ev.type === 'tache' ? ' tache-chip' : '');
                    chip.textContent = ev.label;
                    cell.appendChild(chip);
                }
            });
            body.appendChild(cell);
        });
    });
    cal.appendChild(body);
})();
</script>

<script>
    async function toggleTache(id, checkbox) {
        await fetch('/taches/' + id, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
