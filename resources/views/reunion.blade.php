

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

        @if(isset($reunions[$id]))
            <p> caca pipi </p>
            @if(count($reunions) == 0)
                <p>Il n'y a aucune reunion de prevue</p>
        
        @else 
        <p>gate 0</p>
            @foreach $reunion in $reunions
                <article class="cartes-renunion">
                    <h2><!--CODE PHP pour le nom de la réunion-->SUJET</h2>
                    <h3><!--CODE PHP pour la date de la réunion-->03/04</h3>
                    <h3><!--CODE PHP pour l'heure de la réunion-->15h-16h30</h3>
                    <button><a href="###">Voir</a></button>
                </article>       
        @endif
        @endif
    </section>
</body>
</html>