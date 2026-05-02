<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $fillable = ['user_id', 'nom'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
