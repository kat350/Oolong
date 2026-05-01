<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model {
    protected $fillable = ['user_id', 'titre', 'description', 'date_debut', 'date_fin'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}