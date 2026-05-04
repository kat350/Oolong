<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use Illuminate\Http\Request;

class ReunionsController extends Controller
{
    public function all_reunions()
    {
        // Afficher seulement les réunions de l'utilisateur connecté
        $reunions = Reunion::where('user_id', auth()->id())->get();
        return view('reunion', ['reunions' => $reunions]);
    }

    public function storeReunion(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'date_reunion' => 'required|date',
            'heure_debut'  => 'nullable|date_format:H:i',
            'heure_fin'    => 'nullable|date_format:H:i',
            'description'  => 'nullable|string',
        ]);

        // Ajouter l'utilisateur connecté automatiquement
        $data = $request->all();
        $data['user_id'] = auth()->id();
        
        Reunion::create($data);
        return redirect()->route('reunion')->with('success', 'Réunion ajoutée.');
    }

    // Suppression d'une réunion
    public function destroy(Reunion $reunion)
    {
        // Vérifier que c'est bien l'utilisateur qui a créé la réunion
        if ($reunion->user_id !== auth()->id()) {
            abort(403, 'Non autorisé');
        }

        $reunion->delete();
        return redirect()->route('reunion')->with('success', 'Réunion supprimée.');
    }
}