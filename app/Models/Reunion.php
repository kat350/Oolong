<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'date_reunion',
        'heure_debut',
        'heure_fin',
        'user_id',
    ];

    protected $casts = [
        'date_reunion' => 'date',
    ];

    // Relation avec l'utilisateur qui a créé la réunion
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseur pour formater les heures (15h - 16h30)
    public function getHeureFormatAttribute()
    {
        $debut = $this->heure_debut ? \Carbon\Carbon::parse($this->heure_debut)->format('H\h') : '';
        $fin = $this->heure_fin ? \Carbon\Carbon::parse($this->heure_fin)->format('H\hm') : '';
        
        if ($debut && $fin) {
            return "$debut - $fin";
        } elseif ($debut) {
            return $debut;
        } elseif ($fin) {
            return $fin;
        }
        return '';
    }
}
