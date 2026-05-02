<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use Illuminate\Http\Request;

class ListeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $liste = auth()->user()->listes()->create([
            'nom' => $request->nom,
        ]);

        return response()->json($liste);
    }

    public function destroy(Liste $liste)
    {
        abort_if($liste->user_id !== auth()->id(), 403);

        $liste->taches()->delete();
        $liste->delete();

        return response()->json(['success' => true]);
    }
}
