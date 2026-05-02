<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    // $fillable = les colonnes qu'on autorise à remplir en masse
    // (sécurité : évite qu'un utilisateur malveillant modifie des colonnes sensibles)
    protected $fillable = [
        'sujet',
        'description',
        'date_reunion',
        'heure_debut',
        'heure_fin',
    ];
}
