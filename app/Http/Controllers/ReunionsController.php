<?php

namespace App\Http\Controllers;

use App\Models\Reunion; // ✅ correction : était "Article" et "reunions"
use Illuminate\Http\Request;

class ReunionsController extends Controller
{
    public function all_articles()  // ← pas de virgule après la méthode !
    {
        $reunions = Reunion::all(); // ✅ correction : majuscule + bon modèle
        return view('reunion', [
            "reunions" => $reunions,
            "nom"      => "Blogito"
        ]);
    }

    public function reunionById($id)
    {
        $reunion = Reunion::where('id', $id)->first();
        return view('reunion', ['reunion' => $reunion]);
    }
}
>>>>>>> e6f690d3fd06040e37ec64d16bbbf4528d93c89d
