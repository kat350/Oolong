<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'date_echeance',
        'statut',
        'completee',
    ];

    protected $casts = [
        'completee' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}