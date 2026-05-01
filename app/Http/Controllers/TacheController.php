<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = auth()->user()->taches()->orderBy('created_at', 'desc')->get();
        return view('taches', ['taches' => $taches]);
    }

    public function store(Request $request)
    {
        $request->validate(['description' => 'required|string|max:255']);

        $tache = auth()->user()->taches()->create([
            'titre'         => $request->description,
            'date_echeance' => $request->date_echeance ?? now()->toDateString(),
            'statut'        => 'todo',
            'completee'     => false,
        ]);

        // Si c'est une requête AJAX (page tâches), on retourne du JSON
        if ($request->expectsJson()) {
            return response()->json($tache);
        }

        // Sinon (formulaire du calendrier), on redirige vers le calendrier
        return redirect()->route('calendrier', [
            'mois'  => now()->month,
            'annee' => now()->year,
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