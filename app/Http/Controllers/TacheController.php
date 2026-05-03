<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $listes = auth()->user()->listes()->with('taches')->get();
        $tachesduJour = auth()->user()->taches()
            ->whereDate('created_at', today())
            ->get();
        return view('tache', ['listes' => $listes, 'tachesduJour' => $tachesduJour]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'         => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
            'liste_id'      => 'nullable|exists:listes,id',
            'date_echeance' => 'nullable|date',
            'statut'        => 'nullable|in:todo,en_cours,terminee',
        ]);

        // La page tâches envoie 'description', le calendrier envoie 'titre'
        $titre = $request->titre ?? $request->description;

        if (!$titre) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Le titre est requis.'], 422);
            }
            return back()->withErrors(['titre' => 'Le titre est requis.']);
        }

        if ($request->liste_id) {
            $liste = Liste::findOrFail($request->liste_id);
            abort_if($liste->user_id !== auth()->id(), 403);
        }

        $tache = auth()->user()->taches()->create([
            'liste_id'      => $request->liste_id,
            'titre'         => $titre,
            'description'   => $request->description,
            'date_echeance' => $request->date_echeance ?? today(),
            'statut'        => $request->statut ?? 'todo',
            'completee'     => false,
        ]);

        // Requête JSON (page tâches via fetch) → retourne JSON
        if ($request->expectsJson()) {
            return response()->json($tache);
        }

        // Formulaire classique (page calendrier) → redirige vers le bon mois
        return redirect()->route('calendrier', [
            'mois'  => \Carbon\Carbon::parse($tache->date_echeance)->month,
            'annee' => \Carbon\Carbon::parse($tache->date_echeance)->year,
        ])->with('success', 'Tâche ajoutée !');
    }

    public function toggle(Tache $tache)
    {
        abort_if($tache->user_id !== auth()->id(), 403);

        $tache->update(['completee' => !$tache->completee]);

        return response()->json(['completee' => $tache->completee]);
    }

    public function destroy(Tache $tache)
    {
        abort_if($tache->user_id !== auth()->id(), 403);

        $tache->delete();

        return response()->json(['success' => true]);
    }
}
