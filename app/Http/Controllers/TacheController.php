<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    // affiche page des taches
    public function index()
    {
        // recup listes utilisateur connecté
        $listes = auth()->user()->listes()->with('taches')->get();

        $tachesduJour = auth()->user()->taches()
            ->whereDate('created_at', today())
            ->get();

        return view('tache', ['listes' => $listes, 'tachesduJour' => $tachesduJour]);
    }

    // add nouvelle tache depuis page tache ou calendrier
    public function store(Request $request)
    {
        $request->validate([
            'titre'         => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
            'liste_id'      => 'nullable|exists:listes,id',
            'date_echeance' => 'nullable|date',
            'statut'        => 'nullable|in:todo,en_cours,terminee',
        ]);

        // prend celui qui est rempli pour que les autres pages l'ai, ça synchronise
        $titre = $request->titre ?? $request->description;

        if (!$titre) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Le titre est requis.'], 422);
            }
            return back()->withErrors(['titre' => 'Le titre est requis.']);
        }

        // verif liste appartient a user connecté
        if ($request->liste_id) {
            $liste = Liste::findOrFail($request->liste_id);
            abort_if($liste->user_id !== auth()->id(), 403);
        }

        $tache = auth()->user()->taches()->create([
            'liste_id'      => $request->liste_id,
            'titre'         => $titre,
            'description'   => $request->description,
            'date_echeance' => $request->date_echeance ?? today(), // si pas date on met today
            'statut'        => $request->statut ?? 'todo',
            'completee'     => false,
        ]);

        // selon la requete on renvoie ou redirige
        if ($request->expectsJson()) {
            return response()->json($tache);
        }

        return redirect()->route('calendrier', [
            'mois'  => \Carbon\Carbon::parse($tache->date_echeance)->month,
            'annee' => \Carbon\Carbon::parse($tache->date_echeance)->year,
        ])->with('success', 'Tâche ajoutée !');
    }

    // coche ou decoche la case
    public function toggle(Tache $tache)
    {
        // verif que c'est ma tache avant de modif
        abort_if($tache->user_id !== auth()->id(), 403);

        $tache->update(['completee' => !$tache->completee]);

        return response()->json(['completee' => $tache->completee]);
    }

    // supprime tache
    public function destroy(Tache $tache)
    {
        // verif que c'ets ma tache
        abort_if($tache->user_id !== auth()->id(), 403);

        $tache->delete();

        return response()->json(['success' => true]);
    }
}
