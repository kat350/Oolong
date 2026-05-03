<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   
*@property int $id
*@property int $user_id
*@property int|null $liste_id
*@property string $description
*@property bool $completee
*@property \Carbon\Carbon $start_date*/
class Tache extends Model{

    protected $fillable = [
        'user_id',
        'liste_id',
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
        public function liste()
    {
        return $this->belongsTo(Liste::class);
    }
}