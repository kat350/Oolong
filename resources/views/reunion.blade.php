

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunions</title>
</head>
<body>
    @include('header')
    <section> 
        <h1>Reunions : </h1>
    <button class="btn-ajouter" onclick="ouvrirModal()">+ Ajouter une réunion</button>
<script>        

        function ouvrirModal(date = null) {
            document.getElementById('modal').classList.add('actif');
        }
    

    function fermerModal() {
        document.getElementById('modal').classList.remove('actif');
    }
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) fermerModal();
        });

    function switchTab(type) {
        const formReunion = document.getElementById('form-reunion');
        const tabReunion  = document.getElementById('tab-reunion');
    }
</script>
        <!--VERIFIER REUNIONS-->
        @if(count($reunions) == 0)            
        <p>Il n'y a aucune reunion de prévue</p>   
        @else 
        <!--AFFICHER ELS REUNIONS-->
        @foreach ($reunions as $reunion) 
        <article class='reunion-card'>
         <h2>{{ $reunion['titre'] }}</h2>
         <h3>{{ $reunion['date_reunion'] }}</h3>
         <p>{{ $reunion['heure_debut'], $reunion['heure_fin']}}</p>
        </article>
        @endforeach
        @endif
    </section>
    <div class="modal-overlay" id="modal">
        <div class="modal">
            <h2>Ajouter une réunion</h2>
            <form id="form-reunion" action="{{ route('reunions.store') }}" method="POST">
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
        </div>
    </div>


    
</body>
</html>