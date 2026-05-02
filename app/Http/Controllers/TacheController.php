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
        return view('taches', ['listes' => $listes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'liste_id'    => 'required|exists:listes,id',
        ]);

        $liste = Liste::findOrFail($request->liste_id);
        abort_if($liste->user_id !== auth()->id(), 403);

        $tache = auth()->user()->taches()->create([
            'liste_id'    => $request->liste_id,
            'description' => $request->description,
            'start_date'  => now(),
            'completee'   => false,
        ]);

        return response()->json($tache);
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
