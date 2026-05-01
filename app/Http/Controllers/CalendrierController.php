<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use App\Models\Tache;
use Illuminate\Http\Request;
use Carbon\Carbon; // Carbon = bibliothèque de dates intégrée à Laravel

class CalendrierController extends Controller
{
    /**
     * Affiche le calendrier pour un mois donné
     */
    public function index(Request $request)
    {
        // On récupère le mois et l'année depuis l'URL (?mois=4&annee=2026)
        // Si pas précisé, on prend le mois actuel
        $mois  = $request->get('mois',  now()->month);
        $annee = $request->get('annee', now()->year);

        // Carbon nous aide à manipuler les dates facilement
        $debutMois = Carbon::create($annee, $mois, 1)->startOfMonth();
        $finMois   = Carbon::create($annee, $mois, 1)->endOfMonth();

        // On récupère toutes les réunions du mois
        $reunions = Reunion::where('user_id', auth()->id())
                   ->whereBetween('date_reunion', [$debutMois, $finMois])
                   ->get()
                   ->groupBy('date_reunion');
        // On récupère toutes les tâches du mois
        $taches = Tache::where('user_id', auth()->id())
               ->whereBetween('date_echeance', [$debutMois, $finMois])
               ->get()
               ->groupBy('date_echeance');

        // On passe tout à la vue
        return view('calendrier', [
            'mois'      => $mois,
            'annee'     => $annee,
            'debutMois' => $debutMois,
            'reunions'  => $reunions,
            'taches'    => $taches,
        ]);
    }

    /**
     * Enregistre une nouvelle réunion (appelé depuis le formulaire)
     */
    public function storeReunion(Request $request)
    {
        // Validation : on vérifie que les données sont correctes
        $request->validate([
            'titre'        => 'required|string|max:255',
            'date_reunion' => 'required|date',
            'heure_debut'  => 'nullable|date_format:H:i',
            'heure_fin'    => 'nullable|date_format:H:i',
            'description'  => 'nullable|string',
        ]);

        // Création en BDD
        Reunion::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        // Redirection vers le calendrier avec un message de succès
        return redirect()->route('calendrier', [
            'mois'  => Carbon::parse($request->date_reunion)->month,
            'annee' => Carbon::parse($request->date_reunion)->year,
        ])->with('success', 'Réunion ajoutée !');
    }

    /**
     * Enregistre une nouvelle tâche
     */
    public function storeTache(Request $request)
    {
        $request->validate([
            'titre'         => 'required|string|max:255',
            'date_echeance' => 'required|date',
            'description'   => 'nullable|string',
            'statut'        => 'in:todo,en_cours,terminee',
        ]);

        Tache::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return redirect()->route('calendrier', [
            'mois'  => Carbon::parse($request->date_echeance)->month,
            'annee' => Carbon::parse($request->date_echeance)->year,
        ])->with('success', 'Tâche ajoutée !');
    }
}