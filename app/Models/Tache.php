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
        'description',
        'start_date',
        'completee',
    ];

    protected $casts = [
        'completee' => 'boolean',
        'start_date' => 'datetime',
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