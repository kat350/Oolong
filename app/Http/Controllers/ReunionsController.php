<?php

namespace App\Http\Controllers;

use App\Models\Reunion; // ✅ correction : était "Article" et "reunions"
use Illuminate\Http\Request;

class ReunionsController extends Controller
{
    public function all_reunions()  // ← pas de virgule après la méthode !
    {
        $reunions = Reunion::all(); // ✅ correction : majuscule + bon modèle
        return view('reunion', [
            "reunions" => $reunions]);
    }

    public function reunionById($id)
    {
        $reunion = Reunion::where('id', $id)->first();
        return view('reunion', ['reunion' => $reunion]);
    }



// Nvlle reunion
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
        Reunion::create($request->all());

        return redirect()->route('reunion')->with('success', 'Réunion ajoutée.');
    }
}